<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;
use Cake\Http\Response;

class AiLessonsController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadModel('AiLessons');
        $this->loadModel('AiLessonAttempts');
    }

    public function beforeFilter(EventInterface $event): ?Response
    {
        parent::beforeFilter($event);
        $this->callConstants();
        return null;
    }

    public function admin_index(): ?Response
    {
        $this->viewBuilder()->setLayout('admin_layout');
        $this->set('title_for_layout', SITENAME . ' AI Lessons');
        $this->checkAdminSession();

        $adminId = (int)$this->request->getSession()->read('User.id');
        $lessons = $this->AiLessons->find()
            ->where(['admin_id' => $adminId])
            ->orderDesc('id')
            ->all();
        $this->set(compact('lessons'));
        return null;
    }

    public function adminIndex(): ?Response
    {
        return $this->admin_index();
    }

    public function admin_add(): ?Response
    {
        $this->viewBuilder()->setLayout('admin_layout');
        $this->set('title_for_layout', SITENAME . ' Create AI Lesson');
        $this->checkAdminSession();

        if ($this->request->is('post')) {
            $adminId = (int)$this->request->getSession()->read('User.id');
            $title = trim((string)$this->request->getData('title'));
            $sourceContent = trim((string)$this->request->getData('source_content'));

            if ($title === '' || $sourceContent === '') {
                $this->Flash->error('Title and source content are required.');
                return null;
            }

            $result = $this->generateLessonWithOpenAi($sourceContent);
            if (!$result['success']) {
                $this->Flash->error('AI generation failed: ' . $result['error']);
                return null;
            }

            $lesson = $this->AiLessons->newEntity([
                'admin_id' => $adminId,
                'title' => $title,
                'source_content' => $sourceContent,
                'presentation_json' => json_encode($result['presentation']),
                'quiz_json' => json_encode($result['quiz']),
                'status' => 'published',
            ]);

            if ($this->AiLessons->save($lesson)) {
                $this->Flash->success('AI lesson generated successfully.');
                return $this->redirect(['action' => 'admin_view', $lesson->id]);
            }

            $this->Flash->error('Unable to save AI lesson.');
        }

        return null;
    }

    public function adminAdd(): ?Response
    {
        return $this->admin_add();
    }

    public function admin_view($id = null): ?Response
    {
        $this->viewBuilder()->setLayout('admin_layout');
        $this->set('title_for_layout', SITENAME . ' AI Lesson Preview');
        $this->checkAdminSession();

        $adminId = (int)$this->request->getSession()->read('User.id');
        $id = (int)$id;
        $lesson = $this->AiLessons->find()->where(['id' => $id, 'admin_id' => $adminId])->first();
        if (!$lesson) {
            $this->Flash->error('Lesson not found.');
            return $this->redirect(['action' => 'admin_index']);
        }

        $presentation = $this->decodeJson((string)$lesson->presentation_json);
        $quiz = $this->decodeJson((string)$lesson->quiz_json);
        $attempts = $this->AiLessonAttempts->find()
            ->where(['lesson_id' => $id])
            ->orderDesc('id')
            ->all();

        $this->set(compact('lesson', 'presentation', 'quiz', 'attempts'));
        return null;
    }

    public function adminView($id = null): ?Response
    {
        return $this->admin_view($id);
    }

    public function view($id = null): ?Response
    {
        $this->viewBuilder()->setLayout('default');
        $this->set('title_for_layout', SITENAME . ' Lesson');
        $id = (int)$id;
        $lesson = $this->AiLessons->find()->where(['id' => $id, 'status' => 'published'])->first();
        if (!$lesson) {
            $this->Flash->error('Lesson not found.');
            return $this->redirect('/');
        }

        $presentation = $this->decodeJson((string)$lesson->presentation_json);
        $quiz = $this->decodeJson((string)$lesson->quiz_json);
        $this->set(compact('lesson', 'presentation', 'quiz'));
        return null;
    }

    public function submit($id = null): ?Response
    {
        $this->request->allowMethod(['post']);
        $id = (int)$id;
        $lesson = $this->AiLessons->find()->where(['id' => $id, 'status' => 'published'])->first();
        if (!$lesson) {
            $this->Flash->error('Lesson not found.');
            return $this->redirect('/');
        }

        $quiz = $this->decodeJson((string)$lesson->quiz_json);
        if (empty($quiz)) {
            $this->Flash->error('Quiz is not available for this lesson.');
            return $this->redirect(['action' => 'view', $id]);
        }

        $answers = (array)$this->request->getData('answers');
        $score = 0;
        $total = count($quiz);
        foreach ($quiz as $idx => $q) {
            $correct = isset($q['answer_index']) ? (int)$q['answer_index'] : -1;
            $picked = isset($answers[$idx]) ? (int)$answers[$idx] : -99;
            if ($picked === $correct) {
                $score++;
            }
        }

        $attempt = $this->AiLessonAttempts->newEntity([
            'lesson_id' => $id,
            'student_name' => trim((string)$this->request->getData('student_name')),
            'student_email' => trim((string)$this->request->getData('student_email')),
            'score' => $score,
            'total_questions' => $total,
            'answers_json' => json_encode($answers),
        ]);
        $this->AiLessonAttempts->save($attempt);

        $this->set('score', $score);
        $this->set('total', $total);
        $this->set('lesson', $lesson);
        $this->viewBuilder()->setLayout('default');
        $this->render('result');
        return null;
    }

    protected function generateLessonWithOpenAi(string $sourceContent): array
    {
        $apiKey = (string)(getenv('OPENAI_API_KEY') ?: env('OPENAI_API_KEY'));
        if ($apiKey === '') {
            return ['success' => false, 'error' => 'OPENAI_API_KEY is missing in environment.'];
        }

        $prompt = "You are generating a student-friendly lesson and quiz from provided content.\n"
            . "Return STRICT JSON only with this schema:\n"
            . "{\n"
            . "  \"presentation\": [{\"heading\": \"\", \"points\": [\"\", \"\"]}],\n"
            . "  \"quiz\": [{\"question\": \"\", \"options\": [\"\", \"\", \"\", \"\"], \"answer_index\": 0}]\n"
            . "}\n"
            . "Rules:\n"
            . "- presentation: 5 to 8 sections, each with 2 to 4 short points\n"
            . "- quiz: exactly 5 questions, exactly 4 options each\n"
            . "- answer_index must be 0..3\n"
            . "- no markdown, no explanation, JSON only.\n\n"
            . "Content:\n" . $sourceContent;

        $payload = json_encode([
            'model' => 'gpt-4o-mini',
            'input' => $prompt,
        ]);

        $ch = curl_init('https://api.openai.com/v1/responses');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 45);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $apiKey,
        ]);
        $raw = curl_exec($ch);
        $curlErr = curl_error($ch);
        $status = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($raw === false || $curlErr) {
            return ['success' => false, 'error' => 'Network error: ' . $curlErr];
        }
        if ($status < 200 || $status >= 300) {
            return ['success' => false, 'error' => 'OpenAI API failed (HTTP ' . $status . ').'];
        }

        $json = json_decode((string)$raw, true);
        $text = '';
        if (isset($json['output_text']) && is_string($json['output_text'])) {
            $text = $json['output_text'];
        } elseif (!empty($json['output'][0]['content'][0]['text'])) {
            $text = (string)$json['output'][0]['content'][0]['text'];
        }
        if ($text === '') {
            return ['success' => false, 'error' => 'No AI text output received.'];
        }

        $parsed = json_decode($text, true);
        if (!is_array($parsed)) {
            if (preg_match('/\{.*\}/s', $text, $m)) {
                $parsed = json_decode($m[0], true);
            }
        }
        if (!is_array($parsed)) {
            return ['success' => false, 'error' => 'AI output is not valid JSON.'];
        }

        $presentation = isset($parsed['presentation']) && is_array($parsed['presentation']) ? $parsed['presentation'] : [];
        $quiz = isset($parsed['quiz']) && is_array($parsed['quiz']) ? $parsed['quiz'] : [];
        if (empty($presentation) || empty($quiz)) {
            return ['success' => false, 'error' => 'AI output missing presentation or quiz data.'];
        }

        return ['success' => true, 'presentation' => $presentation, 'quiz' => $quiz];
    }

    protected function decodeJson(string $input): array
    {
        $arr = json_decode($input, true);
        return is_array($arr) ? $arr : [];
    }
}

