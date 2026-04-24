<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;
use Cake\Http\Response;
use Cake\Mailer\MailerAwareTrait;
use Cake\Routing\Router;

/**
 * Mailers Controller (CakePHP 3.10)
 * Specification mailer, EOI mailer, visitor register, price list log.
 */
class MailersController extends AppController
{
    use MailerAwareTrait;

    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Paginator');
        $this->loadModel('User');
        $this->loadModel('Mailer');
        $this->loadModel('NappUser');
        $this->loadModel('EoiMailer');
        $this->loadModel('SpecUsearea');
        $this->loadModel('Visitor');
        $this->loadModel('NewPriceListLog');
        $this->loadModel('MailerComment');
        $this->loadModel('Spec');
        $this->viewBuilder()->setOptions(['ext' => 'php']);
    }

    public function beforeFilter(EventInterface $event): ?Response
    {
        parent::beforeFilter($event);
        $this->callConstants();
        // Use admin layout (with sidebar) for all admin actions except AJAX/partial responses
        $action = $this->request->getParam('action');
        $noLayoutActions = ['admin_title_list', 'admin_list', 'adminList', 'adminTitleList'];
        if (strpos((string)$action, 'admin') === 0 && !in_array($action, $noLayoutActions, true)) {
            $this->viewBuilder()->setLayout('admin_layout');
        }
        return null;
    }

    /**
     * Ensure admin layout is applied right before render (overrides RequestHandler/ajax layout switch).
     * Do not set layout for AJAX/partial actions (admin_list, adminList, admin_title_list, etc.).
     */
    public function beforeRender(EventInterface $event): ?Response
    {
        $result = parent::beforeRender($event);
        if ($result instanceof Response) {
            return $result;
        }
        $action = $this->request->getParam('action');
        $noLayoutActions = ['admin_title_list', 'admin_list', 'adminList', 'adminTitleList'];
        if (strpos((string)$action, 'admin') === 0 && !in_array($action, $noLayoutActions, true)) {
            $this->viewBuilder()->setLayout('admin_layout');
        }
        return null;
    }

    public function admin_visitor(): ?Response
    {
        $this->viewBuilder()->setLayout('admin_layout');
        $this->set('title_for_layout', SITENAME . ' Visitor Register List');
        $this->checkAdminSession();
        $visitors = $this->Visitor->find()->all();
        $this->set('visitors', $visitors);
        return null;
    }

    /** CamelCase alias for URL admin/visitor -> adminVisitor() */
    public function adminVisitor(): ?Response
    {
        return $this->admin_visitor();
    }

    /**
     * Admin: Visitor details page.
     */
    public function admin_visitor_view($id = null): ?Response
    {
        $this->viewBuilder()->setLayout('admin_layout');
        $this->set('title_for_layout', SITENAME . ' Visitor Details');
        $this->checkAdminSession();

        $id = (int)$id;
        if ($id <= 0) {
            $this->Flash->error('Invalid visitor record.');
            return $this->redirect(['action' => 'admin_visitor']);
        }

        try {
            $visitor = $this->Visitor->get($id);
        } catch (\Throwable $e) {
            $this->Flash->error('Visitor record not found.');
            return $this->redirect(['action' => 'admin_visitor']);
        }

        $this->set('visitor', $visitor->toArray());
        return null;
    }

    /**
     * CamelCase alias for dispatcher compatibility.
     */
    public function adminVisitorView($id = null): ?Response
    {
        return $this->admin_visitor_view($id);
    }

    /**
     * Admin: delete visitor record.
     */
    public function admin_visitor_delete($id = null): ?Response
    {
        $this->request->allowMethod(['post', 'delete']);
        $this->checkAdminSession();

        $id = (int)$id;
        if ($id <= 0) {
            $this->Flash->error('Invalid visitor record.');
            return $this->redirect(['action' => 'admin_visitor']);
        }

        try {
            $visitor = $this->Visitor->get($id);
            if ($this->Visitor->delete($visitor)) {
                $this->Flash->success('Visitor record deleted successfully.');
            } else {
                $this->Flash->error('Unable to delete visitor record.');
            }
        } catch (\Throwable $e) {
            $this->Flash->error('Visitor record not found.');
        }

        return $this->redirect(['action' => 'admin_visitor']);
    }

    /**
     * CamelCase alias for dispatcher compatibility.
     */
    public function adminVisitorDelete($id = null): ?Response
    {
        return $this->admin_visitor_delete($id);
    }

    /** CamelCase alias for routing /admin/mailers/eoi */
    public function adminEoi(): ?Response
    {
        return $this->admin_eoi();
    }

    public function admin_eoi(): ?Response
    {
        $this->viewBuilder()->setLayout('admin_layout');
        $this->set('title_for_layout', SITENAME . ' Staff Eoi Mailer');
        $this->checkAdminSession();
        $mailers = $this->EoiMailer->find()
            ->contain(['NappUser' => function ($q) {
                return $q->select(['name', 'lname']);
            }])
            ->orderDesc('EoiMailer.id')
            ->limit(25)
            ->all();
        $this->set('mailers', $mailers);

        // KPI stats for header (admin: site-wide counts; NappUser/kpi shown as N/A)
        $today = date('Y-m-d');
        $totaltoaysent = $this->EoiMailer->find()
            ->where([
                'EoiMailer.created >=' => $today . ' 00:00:00',
                'EoiMailer.created <=' => $today . ' 23:59:59',
            ])
            ->count();
        $totalsent = $this->EoiMailer->find()->count();
        $this->set('totaltoaysent', $totaltoaysent);
        $this->set('totalsent', $totalsent);
        $this->set('NappUser', ['NappUser' => ['kpi' => 'N/A']]);

        return null;
    }


	public function admin_title_list($id = null): ?Response
	{
		$this->request->allowMethod(['get', 'post']);
		$this->viewBuilder()->setLayout(false);
		$this->autoRender = false;
		$html = '';

		$keyword = $this->request->getQuery('keyword') ?? $this->request->getData('keyword');
		if (!empty($keyword)) {
			$keyword = trim($keyword);
			$results = $this->SpecUsearea->find()
				->select(['title'])
				->where([
					'title LIKE' => $keyword . '%',
					'serial !=' => '',
				])
				->group('title')
				->orderAsc('title')
				->all();

			if ($results->count() > 0) {
				$html .= '<ul class="title-dropdown" style="list-style:none;padding-left:0;margin:0;position:absolute;z-index:999;background:#fff;border:1px solid #ccc;max-width:50%;overflow-y: auto;">';
				foreach ($results as $row) {
					$title = h($row->title ?? '');
					$html .= '<li onclick="selectTitle(\'' . addslashes($title) . '\', ' . (int)$id . ')">' . $title . '</li>';
				}
				$html .= '</ul>';
			}
		}
		$this->response = $this->response
			->withType('text/html')
			->withStringBody($html);
		return $this->response;
	}

	/** CamelCase alias for dispatcher compatibility (/admin/mailers/title_list/:id). */
	public function adminTitleList($id = null): ?Response
	{
		return $this->admin_title_list($id);
	}



	// public function admin_list($id=null,$newdiv=null){
	// 	$this->viewBuilder()->setLayout('';
	// 	$userarea = array();
	
	// 	if(!empty($_REQUEST["keyword"])) {
	// 		$query ="SELECT * FROM spec_useareas WHERE product like '" . $_REQUEST["keyword"] . "%' and serial !='' Group By product ORDER BY product ASC  LIMIT 0,6";
	// 		$userarea = $this->SpecUsearea->query($query);
	// 	}
		
	// 	$this->set('userarea', $userarea);	
	// 	$this->set('id', $id);	
	// 	$this->set('newdiv', $newdiv);	
	// }

	/** CamelCase alias for AJAX /admin/mailers/list (dispatcher may expect adminList) */
	public function adminList($id = null, $newdiv = null): ?Response
	{
		return $this->admin_list($id, $newdiv);
	}

	public function admin_list($id = null, $newdiv = null): ?Response
	{
		$this->viewBuilder()->setLayout(false);
		$userarea = [];

		// Accept keyword from GET (query) or POST (AJAX body)
		$keyword = $this->request->getData('keyword') ?? $this->request->getQuery('keyword');
		if (!empty($keyword)) {
			$keyword = trim($keyword);
			$results = $this->SpecUsearea->find()
				->select(['product', 'coverage', 'coverage_by_pack', 'Warranty'])
				->where([
					'product LIKE' => $keyword . '%',
					'serial !=' => '',
				])
				->orderAsc('product')
				->limit(20)
				->all();

			$seen = [];
			foreach ($results as $row) {
				$product = $row->product ?? '';
				// Product-specific default override requested by business.
				if (strcasecmp(trim((string)$product), 'WBE Hi-Build Epoxy') === 0) {
					$row->coverage_by_pack = 'SC';
					$row->Warranty = '10 years';
				}
				$normalized = strtolower(trim(preg_replace('/\(.+\)/', '', $product)));
				if (!in_array($normalized, $seen)) {
					$seen[] = $normalized;
					$userarea[] = ['SpecUsearea' => $row->toArray()];
				}
				if (count($userarea) >= 6) {
					break;
				}
			}
		}

		$this->set('userarea', $userarea);
		$this->set('id', $id);
		$this->set('newdiv', $newdiv);
		return null;
	}


	// new_code deepak

	/** Called when URL is /mailers/index_v3 (no admin prefix). Redirect to admin version. */
	public function indexV3(): ?Response
	{
		return $this->redirect(\Cake\Routing\Router::url(['controller' => 'Mailers', 'action' => 'admin_index_v3'], true));
	}

	/** CamelCase alias for route /admin/mailers/index_v3 (dispatcher may expect adminIndexV3) */
	public function adminIndexV3(): ?Response
	{
		return $this->admin_index_v3();
	}

	public function admin_index_v3(): ?Response
	{
		$this->viewBuilder()->setLayout('admin_layout');
		$this->set('title_for_layout', SITENAME . ' DuroEzy Specification Mailer');
		$this->checkAdminSession();
		$user_id = $this->request->getSession()->read('User.id');

		// DuroEzy Spec v3: show specs created by admin with spec_v = 1 (from send_v3)
		$results = $this->Mailer->find()
			->contain(['User' => function ($q) { return $q->select(['name', 'username']); }, 'NappUser' => function ($q) { return $q->select(['name', 'lname']); }])
			->where(['Mailer.spec_v' => 0, 'Mailer.admin_id' => $user_id])
			->orderDesc('Mailer.id')
			;
		$filters = [
			'tracknumber' => trim((string)$this->request->getQuery('tracknumber')),
			'name' => trim((string)$this->request->getQuery('name')),
			'email' => trim((string)$this->request->getQuery('email')),
			'company' => trim((string)$this->request->getQuery('company')),
			'specification' => trim((string)$this->request->getQuery('specification')),
			'date_from' => trim((string)$this->request->getQuery('date_from')),
			'date_to' => trim((string)$this->request->getQuery('date_to')),
		];
		if ($filters['tracknumber'] !== '') {
			$results->andWhere(['Mailer.tracknumber LIKE' => '%' . $filters['tracknumber'] . '%']);
		}
		if ($filters['name'] !== '') {
			$results->andWhere(['Mailer.name LIKE' => '%' . $filters['name'] . '%']);
		}
		if ($filters['email'] !== '') {
			$results->andWhere(['Mailer.email LIKE' => '%' . $filters['email'] . '%']);
		}
		if ($filters['company'] !== '') {
			$results->andWhere(['Mailer.company LIKE' => '%' . $filters['company'] . '%']);
		}
		if ($filters['specification'] !== '') {
			$results->andWhere(['Mailer.specification LIKE' => '%' . $filters['specification'] . '%']);
		}
		if ($filters['date_from'] !== '') {
			$results->andWhere(['Mailer.date >=' => $filters['date_from']]);
		}
		if ($filters['date_to'] !== '') {
			$results->andWhere(['Mailer.date <=' => $filters['date_to']]);
		}
		if ($this->Mailer->getSchema()->getColumn('save_status')) {
			$results->andWhere([
				'OR' => [
					['Mailer.save_status IS' => null],
					['Mailer.save_status !=' => 'draft'],
				],
			]);
		}
		$results = $results->all();

		$mailers = [];
		foreach ($results as $row) {
			$mailers[] = [
				'Mailer' => $row->toArray(),
				'User' => $row->user ? $row->user->toArray() : [],
				'NappUser' => $row->napp_user ? $row->napp_user->toArray() : [],
			];
		}
		$hasDraft = false;
		if ($this->Mailer->getSchema()->getColumn('save_status')) {
			$hasDraft = $this->Mailer->exists([
				'Mailer.admin_id' => $user_id,
				'Mailer.type' => 3,
				'Mailer.save_status' => 'draft',
			]);
		}
		$this->set(compact('mailers', 'hasDraft', 'filters'));
		return null;
	}



	/** CamelCase alias for route /admin/mailers (dispatcher expects adminIndex) */
	public function adminIndex(): ?Response
	{
		return $this->admin_index();
	}

	public function admin_index(): ?Response
	{
		$this->viewBuilder()->setLayout('admin_layout');
		$this->set('title_for_layout', SITENAME . ' DuroEzy Specification Mailer');
		$redirect = $this->checkAdminSession();
		if ($redirect instanceof Response) {
			return $redirect;
		}
		$user_id = $this->request->getSession()->read('User.id');

		$results = $this->Mailer->find()
			->contain(['User' => function ($q) { return $q->select(['name', 'username']); }, 'NappUser' => function ($q) { return $q->select(['name', 'lname']); }])
			->where(['spec_v' => 0, 'admin_id' => $user_id])
			->orderDesc('Mailer.id')
			->all();

		$mailers = [];
		foreach ($results as $row) {
			$mailers[] = [
				'Mailer' => $row->toArray(),
				'User' => $row->user ? $row->user->toArray() : [],
				'NappUser' => $row->napp_user ? $row->napp_user->toArray() : [],
			];
		}
		$this->set('mailers', $mailers);
		return null;
	}

	/** CamelCase alias for route /admin/mailers/sendemail (dispatcher may expect adminSendemail) */
	public function adminSendemail($id = null): ?Response
	{
		return $this->admin_sendemail($id);
	}

	public function admin_sendemail($id = null): ?Response
	{
		$this->checkAdminSession();
		$id = (int)$id;
		$mailer = $this->Mailer->get($id);
		if (!$mailer) {
			$this->Flash->error('Record not found.');
			return $this->redirect(\Cake\Routing\Router::url(['controller' => 'Mailers', 'action' => 'admin_index'], true));
		}

		// Validate email address - handle null, empty string, or whitespace
		$to = isset($mailer->email) ? (string)$mailer->email : '';
		$to = trim($to);
		
		if (empty($to) || $to === '') {
			$this->Flash->error('Cannot send email: No email address specified for this spec (ID: ' . $id . '). Please edit the spec and add an email address.');
			return $this->redirect(\Cake\Routing\Router::url(['controller' => 'Mailers', 'action' => 'admin_index'], true));
		}

		// Validate email format
		if (!filter_var($to, FILTER_VALIDATE_EMAIL)) {
			$this->Flash->error('Cannot send email: Invalid email address format: "' . htmlspecialchars($to) . '". Please edit the spec and correct the email address.');
			return $this->redirect(\Cake\Routing\Router::url(['controller' => 'Mailers', 'action' => 'admin_index'], true));
		}

		$pdfname = base64_encode(base64_encode($mailer->id . '-' . $mailer->tracknumber . '.pdf'));
		$subject = $mailer->subject ?? 'Your specification';
		$vars = [
			'subject' => $subject,
			'pdfname' => $pdfname,
			'name' => $mailer->name ?? '',
			'address' => $mailer->address ?? '',
			'company' => $mailer->company ?? '',
			'specification' => $mailer->specification ?? '',
			'email' => $to,
			'date' => $mailer->date ?? '',
		];

		// Final validation check before sending
		if (empty($to) || !filter_var($to, FILTER_VALIDATE_EMAIL)) {
			$this->Flash->error('Cannot send email: Email validation failed. Email: "' . htmlspecialchars($to) . '"');
			return $this->redirect(\Cake\Routing\Router::url(['controller' => 'Mailers', 'action' => 'admin_index'], true));
		}

		try {
			$this->getMailer('Spec')->send('sendSpec', [$to, $subject, $vars]);
			$this->Flash->success('Email sent successfully to ' . htmlspecialchars($to) . '.');
		} catch (\InvalidArgumentException $e) {
			// Handle validation errors from SpecMailer
			$this->Flash->error('Email validation error: ' . $e->getMessage());
		} catch (\Throwable $e) {
			$this->Flash->error('Failed to send email: ' . $e->getMessage());
		}
		return $this->redirect(\Cake\Routing\Router::url(['controller' => 'Mailers', 'action' => 'admin_index'], true));
	}

	public function download($id): ?Response
	{
		$this->request->allowMethod(['get']);
		$decoded = base64_decode(base64_decode($id), true);
		if ($decoded === false || $decoded === '') {
			$this->Flash->error('Invalid link.');
			return $this->redirect(\Cake\Routing\Router::url(['controller' => 'Mailers', 'action' => 'admin_index'], true));
		}
		$url = rtrim(SITEURL, '/') . '/dompdf/' . $decoded;
		return $this->redirect($url);
	}

		//new_code

	/** CamelCase alias for route /admin/mailers/send_v3 (dispatcher may expect adminSendV3) */
	public function adminSendV3()
	{
		return $this->admin_send_v3();
	}

	public function admin_send_v3() {
		
		$this->viewBuilder()->setLayout('admin_layout');
		$this->set('title_for_layout',SITENAME.' DuroEzy Specification Mailer');
		$this->checkAdminSession(); 
		$user_id=$this->request->getSession()->read('User.id');
		$hasSaveStatusColumn = $this->Mailer->getSchema()->getColumn('save_status');
		if (!empty($this->request->getData())) {
			$draftIdFromForm = (int)$this->request->getData('draft_id');
			
			//new_code deepak

			$uploadPath = WWW_ROOT . 'uploads' . DS . 'datasheets' . DS;
			if (!file_exists($uploadPath)) {
				mkdir($uploadPath, 0777, true);
			}
			$pdfAttachment = '';
			if (!empty($this->request->getData('datasheet_pdf')['tmp_name'])) {
				$file = $this->request->getData('datasheet_pdf');
				$ext = pathinfo($file['name'], PATHINFO_EXTENSION);
				$filename = time() . '_' . preg_replace('/[^a-zA-Z0-9_\-\.]/', '_', $file['name']);
				$fullPath = $uploadPath . $filename;
				move_uploaded_file($file['tmp_name'], $fullPath);
				$pdfAttachment = 'uploads/datasheets/' . $filename;
			}
			
			$tracknumber = $this->request->getData()['tracknumber'];
			$name = $this->request->getData()['name'];
			$email = $this->request->getData()['email'];
			$company = $this->request->getData()['company'];
			$address = $this->request->getData()['address'];
			$specification = $this->request->getData()['specification'];
			$date = null;
			if (!empty($this->request->getData()['date'])) {
				$date = date('Y-m-d', strtotime(str_replace('/', '-', $this->request->getData()['date'])));
			}
			$type = $this->request->getData()['type'];
			$subject = $this->request->getData()['subject'];
			//$mft = $this->request->getData()['mft'];
			//$warranty_period = $this->request->getData()['warranty_period'];
			isset($this->request->getData()['use_area'])? $use_area = $this->request->getData()['use_area'] : $use_area =1;
			
			// Build full Mailer entity data (all fields in one array for newEntity)
			$mailerData = [
				'admin_id' => $user_id,
				'name' => $name,
				'tracknumber' => $tracknumber,
				'address' => $address,
				'specification' => $specification,
				'date' => $date,
				'email' => $email,
				'company' => $company,
				'type' => (int)$type,
				'subject' => $subject,
				'use_area' => (int)$use_area,
				'spec_v' => 1,
				'created' => date('Y-m-d H:i:s'),
			];
			if ($hasSaveStatusColumn) {
				$mailerData['save_status'] = 'submitted';
			}
			if ($pdfAttachment !== '') {
				$mailerData['pdf_attachment'] = $pdfAttachment;
			}

			if ($hasSaveStatusColumn && $draftIdFromForm > 0) {
				$existingDraft = $this->Mailer->find()
					->where([
						'Mailer.id' => $draftIdFromForm,
						'Mailer.admin_id' => $user_id,
						'Mailer.save_status' => 'draft',
					])
					->first();
				if ($existingDraft) {
					$mailerEntity = $this->Mailer->patchEntity($existingDraft, $mailerData);
				} else {
					$mailerEntity = $this->Mailer->newEntity($mailerData);
				}
			} else {
				// Keep one active admin draft only; remove stale draft when submitting new one.
				if ($hasSaveStatusColumn) {
					$oldDraftIds = $this->Mailer->find()
						->select(['id'])
						->where([
							'Mailer.admin_id' => $user_id,
							'Mailer.type' => 3,
							'Mailer.save_status' => 'draft',
						])
						->enableHydration(false)
						->all()
						->extract('id')
						->toArray();
					if (!empty($oldDraftIds)) {
						$this->MailerComment->deleteAll(['mailer_id IN' => $oldDraftIds]);
						$this->SpecUsearea->deleteAll(['mailer_id IN' => $oldDraftIds]);
						$this->Mailer->deleteAll(['id IN' => $oldDraftIds]);
					}
				}
				$mailerEntity = $this->Mailer->newEntity($mailerData);
			}
			if ($this->Mailer->save($mailerEntity)) {
				$lastinsertId = $mailerEntity->id;
				
				if (!empty($this->request->getData()['comment'])) {
					foreach ($this->request->getData()['comment'] as $comment) {
						$commentEntity = $this->MailerComment->newEntity([
							'mailer_id' => $lastinsertId,
							'use_area' => 1,
							'comment' => $comment,
						]);
						$this->MailerComment->save($commentEntity);
					}
				}
				
				if (!empty($this->request->getData()['product'])) {
					$data = $this->request->getData();
					foreach ($data['product'] as $key => $prodt) {
						$title = isset($data['title'][$data['types'][$key]]) ? $data['title'][$data['types'][$key]] : '';
						$specEntity = $this->SpecUsearea->newEntity([
							'mailer_id' => $lastinsertId,
							'use_area' => 1,
							'title' => $title,
							'product' => $prodt,
							'types' => $data['types'][$key] ?? null,
							'serial' => $data['serial'][$key] ?? '',
							'coverage' => $data['coverage'][$key] ?? '',
							'Warranty' => $data['Warranty'][$key] ?? '',
							'coverage_by_pack' => $data['coverage_by_pack'][$key] ?? '',
						]);
						$this->SpecUsearea->save($specEntity);
					}
				}
				
				$pdfname = $lastinsertId . '-' . $tracknumber;
				$dateVal = $this->request->getData('date');
				$fields = array(
					'tracknumber' => urlencode((string)$tracknumber),
					'mailer_id' => urlencode((string)$lastinsertId),
					'name' => urlencode((string)$name),
					'email' => urlencode((string)$email),
					'address' => urlencode((string)$address),
					'company' => urlencode((string)$company),
					'specification' => urlencode((string)$specification),
					'date' => urlencode((string)$dateVal),
					'subject' => urlencode((string)$subject),
					'type' => urlencode((string)$type),
					'pdfname' => urlencode((string)$pdfname),
					'use_area' => urlencode((string)$use_area),
				);
				$fields_string = '';
				foreach ($fields as $key => $value) {
					$fields_string .= $key . '=' . $value . '&';
				}
				$fields_string = rtrim($fields_string, '&');
				if ($this->request->getData('spectype') == 1) {
					$url = SITEURL.'dompdf/generatepdf.php?'.$fields_string;
				} else {
					$url = SITEURL.'dompdf/generatewithoutpdf.php?'.$fields_string;
				}
				$arrContextOptions=array(
					"ssl"=>array(
						"verify_peer"=>false,
						"verify_peer_name"=>false,
					),
				);  
				$result = file_get_contents($url, false, stream_context_create($arrContextOptions));
				$pdfPath = 'dompdf/' . $pdfname . '-V2.pdf';
				$absPdfPath = WWW_ROOT . str_replace('/', DS, $pdfPath);
				if (is_file($absPdfPath)) {
					$mailerEntity->pdf_attachment = $pdfPath;
				} else {
					// Fallback to stable generator when v1 doesn't create a file.
					$fallbackUrl = SITEURL . 'dompdf/generatepdf.php?' . $fields_string;
					$fallbackResponse = @file_get_contents($fallbackUrl, false, stream_context_create($arrContextOptions));
					if ($fallbackResponse !== false) {
						$fallbackJson = json_decode((string)$fallbackResponse, true);
						if (is_array($fallbackJson) && !empty($fallbackJson['success'])) {
							$mailerEntity->pdf_attachment = (string)($fallbackJson['path'] ?? ('dompdf/' . ($fallbackJson['filename'] ?? '')));
						}
					}
				}
				$this->Mailer->save($mailerEntity);
				
				$this->Flash->success('Spec saved successfully.');
				return $this->redirect(\Cake\Routing\Router::url('/mailers/index_v3'));
			}
		}
		$refernce = $this->Mailer->getNextSpecTrackNumber();
		$draft = null;
		$draftId = null;
		$resumeDraft = $this->request->getQuery('resume') && $hasSaveStatusColumn;
		if ($resumeDraft) {
			$draft = $this->Mailer->find()
				->where([
					'Mailer.admin_id' => $user_id,
					'Mailer.type' => 3,
					'Mailer.save_status' => 'draft',
				])
				->orderDesc('Mailer.id')
				->first();
			if ($draft) {
				$draftId = (int)$draft->id;
				$draft->comments = $this->MailerComment->find()->where(['mailer_id' => $draftId])->all();
				$draft->spec_useareas = $this->SpecUsearea->find()->where(['mailer_id' => $draftId])->orderAsc('id')->all();
			}
		}
		$this->set(compact('refernce', 'draft', 'draftId'));
	}

	/** AJAX autosave for admin spec v3 draft. */
	public function admin_specDraftAutosaveV3(): ?Response
	{
		$this->request->allowMethod(['post']);
		$this->viewBuilder()->setLayout(false);
		$this->autoRender = false;
		$this->checkAdminSession();

		$user_id = (int)$this->request->getSession()->read('User.id');
		$hasSaveStatusColumn = $this->Mailer->getSchema()->getColumn('save_status');
		if (!$hasSaveStatusColumn) {
			$this->response = $this->response->withType('application/json')
				->withStringBody(json_encode(['success' => false, 'error' => 'Draft not configured.']));
			return $this->response;
		}

		$data = (array)$this->request->getData();
		$draftIdFromForm = isset($data['draft_id']) ? (int)$data['draft_id'] : 0;
		$exp = explode('/', (string)($data['date'] ?? date('d/m/Y')));
		$date = (count($exp) === 3) ? ($exp[2] . '-' . $exp[1] . '-' . $exp[0]) : date('Y-m-d');
		$use_area = isset($data['use_area']) ? (int)$data['use_area'] : 1;

		$entity = null;
		if ($draftIdFromForm > 0) {
			$entity = $this->Mailer->find()
				->where([
					'Mailer.id' => $draftIdFromForm,
					'Mailer.admin_id' => $user_id,
					'Mailer.save_status' => 'draft',
				])
				->first();
		}
		if (!$entity) {
			$entity = $this->Mailer->newEntity([
				'admin_id' => $user_id,
				'type' => 3,
				'spec_v' => 1,
				'save_status' => 'draft',
				'created' => date('Y-m-d H:i:s'),
			]);
		}

		$entity = $this->Mailer->patchEntity($entity, [
			'name' => (string)($data['name'] ?? ''),
			'tracknumber' => '',
			'address' => (string)($data['address'] ?? ''),
			'specification' => (string)($data['specification'] ?? ''),
			'date' => $date,
			'email' => (string)($data['email'] ?? ''),
			'company' => (string)($data['company'] ?? ''),
			'type' => (int)($data['type'] ?? 3),
			'subject' => (string)($data['subject'] ?? ''),
			'use_area' => $use_area,
			'spec_v' => 1,
			'save_status' => 'draft',
		]);

		if (!$this->Mailer->save($entity)) {
			$this->response = $this->response->withType('application/json')
				->withStringBody(json_encode(['success' => false, 'error' => 'Save failed.']));
			return $this->response;
		}

		$draftId = (int)$entity->id;
		$this->MailerComment->deleteAll(['mailer_id' => $draftId]);
		$this->SpecUsearea->deleteAll(['mailer_id' => $draftId]);

		if (!empty($data['comment']) && is_array($data['comment'])) {
			foreach ($data['comment'] as $comment) {
				$this->MailerComment->save($this->MailerComment->newEntity([
					'mailer_id' => $draftId,
					'use_area' => 1,
					'comment' => (string)$comment,
				]));
			}
		}
		if (!empty($data['product']) && is_array($data['product'])) {
			foreach ($data['product'] as $key => $prodt) {
				$typesKey = $data['types'][$key] ?? null;
				$title = isset($data['title'][$typesKey]) ? $data['title'][$typesKey] : '';
				$this->SpecUsearea->save($this->SpecUsearea->newEntity([
					'mailer_id' => $draftId,
					'use_area' => 1,
					'title' => $title,
					'product' => $prodt,
					'types' => $data['types'][$key] ?? '',
					'serial' => $data['serial'][$key] ?? '',
					'coverage' => $data['coverage'][$key] ?? '',
					'Warranty' => $data['Warranty'][$key] ?? '',
					'coverage_by_pack' => $data['coverage_by_pack'][$key] ?? '',
				]));
			}
		}

		$this->response = $this->response->withType('application/json')
			->withStringBody(json_encode(['success' => true, 'draft_id' => $draftId]));
		return $this->response;
	}

	/** CamelCase alias for dispatcher compatibility. */
	public function adminSpecDraftAutosaveV3(): ?Response
	{
		return $this->admin_specDraftAutosaveV3();
	}

	/** CamelCase alias for route /admin/mailers/send (dispatcher may expect adminSend) */
	public function adminSend()
	{
		return $this->admin_send();
	}

	public function admin_send() {
		
		$this->viewBuilder()->setLayout('admin_layout');
		$this->set('title_for_layout',SITENAME.' DuroEzy Specification Mailer');
		$this->checkAdminSession(); 
		$user_id=$this->request->getSession()->read('User.id');
		
		if (!empty($this->request->getData())) {

			$isDraft = isset($this->request->getData()['save_draft']);

			
			//new_code deepak

			$uploadPath = WWW_ROOT . 'uploads' . DS . 'datasheets' . DS;
			if (!file_exists($uploadPath)) {
				mkdir($uploadPath, 0777, true);
			}

        if (!empty($this->request->getData()['Mailer']['datasheet_pdf']['tmp_name'])) {
			
               $file = $this->request->getData()['Mailer']['datasheet_pdf'];

				$ext = pathinfo($file['name'], PATHINFO_EXTENSION);
				$filename = time() . '_' . preg_replace('/[^a-zA-Z0-9_\-\.]/', '_', $file['name']);
				$fullPath = $uploadPath . $filename;
				move_uploaded_file($file['tmp_name'], $fullPath);

				// Store relative path or full URL in database
				$inserty['Mailer']['pdf_attachment'] = 'uploads/datasheets/' . $filename;
			}
			
			$tracknumber = $this->request->getData()['tracknumber'];
			$name = $this->request->getData()['name'];
			$email = $this->request->getData()['email'];
			$company = $this->request->getData()['company'];
			$address = $this->request->getData()['address'];
			$specification = $this->request->getData()['specification'];
			$date = null;
			if (!empty($this->request->getData()['date'])) {
				$date = date('Y-m-d', strtotime(str_replace('/', '-', $this->request->getData()['date'])));
			}
			$type = $this->request->getData()['type'];
			$subject = $this->request->getData()['subject'];
			//$mft = $this->request->getData()['mft'];
			//$warranty_period = $this->request->getData()['warranty_period'];
			isset($this->request->getData()['use_area'])? $use_area = $this->request->getData()['use_area'] : $use_area =1;
			
			$inserty['Mailer']['admin_id'] = $user_id;
			$inserty['Mailer']['name'] = $name;
			$inserty['Mailer']['tracknumber'] = $tracknumber;
			$inserty['Mailer']['address'] = $address;
			$inserty['Mailer']['specification'] = $specification;
			$inserty['Mailer']['date'] = $date;
			$inserty['Mailer']['email'] = $email;
			$inserty['Mailer']['company'] = $company;
			$inserty['Mailer']['type'] = $type;
			$inserty['Mailer']['subject'] = $subject;
			$inserty['Mailer']['use_area'] = $use_area;
			//$inserty['Mailer']['mft'] = $mft;
			//$inserty['Mailer']['warranty_period'] = $warranty_period;
			$inserty['Mailer']['created'] = date('Y-m-d H:i:s');
			$inserty['Mailer']['save_status'] = $isDraft ? 'draft' : 'submitted';

			$mailerEntity = $this->Mailer->newEntity($inserty['Mailer']);
			if ($this->Mailer->save($mailerEntity)) {
				$lastinsertId = $mailerEntity->id;

				if (!empty($this->request->getData()['comment'])) {
					foreach ($this->request->getData()['comment'] as $comment) {
						$commentEntity = $this->MailerComment->newEntity([
							'mailer_id' => $lastinsertId,
							'use_area' => 1,
							'comment' => $comment,
						]);
						$this->MailerComment->save($commentEntity);
					}
				}

				if (!empty($this->request->getData()['product'])) {
					$data = $this->request->getData();
					foreach ($data['product'] as $key => $prodt) {
						$title = isset($data['title'][$data['types'][$key]]) ? $data['title'][$data['types'][$key]] : '';
						$specEntity = $this->SpecUsearea->newEntity([
							'mailer_id' => $lastinsertId,
							'use_area' => 1,
							'title' => $title,
							'product' => $prodt,
							'types' => $data['types'][$key] ?? null,
							'serial' => $data['serial'][$key] ?? '',
							'coverage' => $data['coverage'][$key] ?? '',
							'Warranty' => $data['Warranty'][$key] ?? '',
							'coverage_by_pack' => $data['coverage_by_pack'][$key] ?? '',
						]);
						$this->SpecUsearea->save($specEntity);
					}
				}


				if (!$isDraft) 
					{
						$pdfname = $lastinsertId . '-' . $tracknumber;
						$dateVal = $this->request->getData('date');
						$fields = array(
						'tracknumber' => urlencode((string) $tracknumber),
						'mailer_id' => urlencode((string) $lastinsertId),
						'name' => urlencode((string) $name),
						'email' => urlencode((string) $email),
						'address' => urlencode((string) $address),
						'company' => urlencode((string) $company),
						'specification' => urlencode((string) $specification),
						'date' => urlencode((string) $dateVal),
						'subject' => urlencode((string) $subject),
						'type' => urlencode((string) $type),
						'pdfname' => urlencode((string) $pdfname),
						'use_area' => urlencode((string) $use_area),
					  );		
																	
						$fields_string = '';
						foreach ($fields as $key => $value) {
							$fields_string .= $key . '=' . $value . '&';
						}
						$fields_string = rtrim($fields_string, '&');
						$baseUrl = Router::url('/', true);
						$pdfScript = ($this->request->getData('spectype') == 1) ? 'dompdf/generatepdf.php' : 'dompdf/generatewithoutpdf.php';
						$url = rtrim($baseUrl, '/') . '/' . $pdfScript . '?' . $fields_string;
						$arrContextOptions = [
							'http' => [
								'timeout' => 30,
								'ignore_errors' => true,
							],
							'ssl' => [
								'verify_peer' => false,
								'verify_peer_name' => false,
							],
						];
						$result = @file_get_contents($url, false, stream_context_create($arrContextOptions));
						
						// Parse JSON response from generatepdf.php
						$pdfData = null;
						if ($result !== false && !empty($result)) {
							$pdfData = @json_decode($result, true);
							if (json_last_error() !== JSON_ERROR_NONE) {
								// Not JSON - might be an error message
								\Cake\Log\Log::error('PDF generation returned non-JSON response for mailer_id ' . $lastinsertId . ': ' . substr($result, 0, 500));
								$pdfData = null;
							}
						}
						
						if ($pdfData && isset($pdfData['success']) && $pdfData['success'] === true) {
							// Use the filename returned by generatepdf.php
							$pdfPath = $pdfData['path'] ?? 'dompdf/' . $pdfData['filename'];
							
							// Verify file actually exists
							$fullPath = WWW_ROOT . str_replace('/', DS, $pdfPath);
							if (file_exists($fullPath)) {
								// Save PDF path to database
								$mailerEntity = $this->Mailer->get($lastinsertId);
								$mailerEntity->pdf_attachment = $pdfPath;
								$this->Mailer->save($mailerEntity);
							} else {
								// Log error but don't fail the request
								\Cake\Log\Log::error('PDF file not found after generation: ' . $fullPath . ' (Expected from: ' . $url . ')');
							}
						} else {
							// PDF generation failed - log the error
							$errorMsg = ($result !== false && !empty($result)) ? substr($result, 0, 500) : 'Empty response or connection failed';
							\Cake\Log\Log::error('PDF generation failed for mailer_id ' . $lastinsertId . ' (URL: ' . $url . '): ' . $errorMsg);
							// Don't fail the request - user can regenerate PDF later
						}
						
						$this->Flash->success('PDF file generated successfully.');
						return $this->redirect(\Cake\Routing\Router::url(['controller' => 'Mailers', 'action' => 'admin_index'], true));

			        } else {
						$this->Flash->success('Draft saved successfully.');
						return $this->redirect(\Cake\Routing\Router::url(['controller' => 'Mailers', 'action' => 'admin_index'], true));
					}
			}
		}


		$refrmon = array('01'=>'a','02'=>'b','03'=>'c','04'=>'d','05'=>'e','06'=>'f','07'=>'g','08'=>'h','09'=>'i','10'=>'j','11'=>'k','12'=>'l');
		$mailerid = (int) $this->Mailer->find()->where(['type' => 3])->count();
		$id = $mailerid + 1;
		$idStr = (string) $id;

		$yr = date('y');
		$mm = date('m');
		if (strlen($idStr) === 1) {
			$code = '00' . $id;
		} elseif (strlen($idStr) === 2) {
			$code = '0' . $id;
		} else {
			$code = (string) $id;
		}			
		$refernce = 'DTSPEC '.$yr.'-'.$mm.'-'.$code; 
		$this->set('refernce',$refernce);
	}
	
	public function index(){		
		
		$this->viewBuilder()->setLayout('staff_inner_layout');
		$this->set('title_for_layout',SITENAME.' DuroEzy Specification Mailer');		
		$this->checkSatffSession(); 
		 $customer_id=$this->request->getSession()->read('Customer.id');
		
		$this->Mailer->recursive = 0;
		$this->paginate = array('conditions'=>array('spec_v'=>0,'Mailer.user_id'=>$customer_id),'page' => 1, 'limit' => 25,'order'=>array('Mailer.id'=>'desc'));
		$mailers = $this->Paginator->paginate('Mailer');

		// echo '<pre>';
		// print_r($mailers);
		// die();
		
		$this->set('mailers', $mailers);		
	}
	
	public function send() {
		
		$this->viewBuilder()->setLayout('staff_inner_layout');
		$this->set('title_for_layout',SITENAME.' DuroEzy Specification Mailer');
		$this->checkSatffSession(); 
		$user_id=$this->request->getSession()->read('Customer.id');
		if (!empty($this->request->getData())) {
			
			$name = $this->request->getData()['name'];
			$email = $this->request->getData()['email'];
			$phone = $this->request->getData()['phone'];
			$company = $this->request->getData()['company'];
			$project = $this->request->getData()['project'];
			$type = $this->request->getData()['type'];
			$subject = $this->request->getData()['subject'];
			
			$inserty['Mailer']['user_id'] = $user_id;
			$inserty['Mailer']['name'] = $name;
			$inserty['Mailer']['email'] = $email;
			$inserty['Mailer']['phone'] = $phone;
			$inserty['Mailer']['company'] = $company;
			$inserty['Mailer']['project'] = $project;
			$inserty['Mailer']['type'] = $type;
			$inserty['Mailer']['subject'] = $subject;
			$inserty['Mailer']['created'] = date('Y-m-d H:i:s');			
			if($this->Mailer->save($inserty)){
				
				$url = SITEURL.'DuroEzy/sendemail.php';
				$fields = array(
					'name' => urlencode($name),
					'email' => urlencode($email),				
					'phone' => urlencode($phone),
					'company' => urlencode($company),
					'project' => urlencode($project),
					'subject' => urlencode($subject),
					'type' => urlencode($type)
				);											
				$fields_string = '';
				//url-ify the data for the POST
				foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
				rtrim($fields_string, '&');
				
				//open connection
				$ch = curl_init();

				//set the url, number of POST vars, POST data
				curl_setopt($ch,CURLOPT_URL, $url);
				curl_setopt($ch,CURLOPT_POST, count($fields));
				curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);

				//execute post
				$result = curl_exec($ch);
				//close connection
				curl_close($ch);
				
				$this->Flash->success('Emailer sent successfully');
				return $this->redirect(array('action' => 'index'));
			}
		}
		
	}
	
	public function eoi(){
		$this->viewBuilder()->setLayout('staff_inner_layout');
		$this->set('title_for_layout', SITENAME . ' Staff Eoi Mailer');
		$this->checkSatffSession();
		$customer_id = $this->request->getSession()->read('Customer.id');

		$NappUser = $this->NappUser->find()->where(['NappUser.id' => $customer_id])->first();
		$this->set('NappUser', $NappUser);

		$mailers = $this->paginate($this->EoiMailer->find()
			->where(['EoiMailer.user_id' => $customer_id])
			->orderDesc('EoiMailer.id'), [
			'limit' => 25,
		]);
		$this->set('mailers', $mailers);

		$date = date('Y-m-d');
		$totaltoaysent = $this->EoiMailer->find()->where([
			'EoiMailer.user_id' => $customer_id,
			'DATE(EoiMailer.created)' => $date,
		])->count();
		$this->set('totaltoaysent', $totaltoaysent);

		$totalsent = $this->EoiMailer->find()->where(['EoiMailer.user_id' => $customer_id])->count();
		$this->set('totalsent', $totalsent);
	}
	
	public function eoisend() {
		$this->viewBuilder()->setLayout('staff_inner_layout');
		$this->set('title_for_layout',SITENAME.' Send Eoi Mailer');
		$this->checkSatffSession(); 
		$user_id=$this->request->getSession()->read('Customer.id');
		if (!empty($this->request->getData())) {
			
			if(!empty($this->request->getData()['inserIndivdualtname'])){
				$client_requested = $this->request->getData()['client_requested'];
				
				for($i=0; $i<count($this->request->getData()['inserIndivdualtname']); $i++){
					
					
									
					$mailerid = $this->EoiMailer->find()->orderDesc('EoiMailer.id')->count();
					$id = $mailerid + 1;
					$yr = date('y');
					$mm = date('m');
					$idStr = (string)$id;
					if (strlen($idStr) == 1) {
						$code = '00' . $idStr;
					} elseif (strlen($idStr) == 2) {
						$code = '0' . $idStr;
					} else {
						$code = $idStr;
					}
					$mailer_id = 'DTEOI ' . $yr . '-' . $mm . '-' . $code; 				
					
					$inserIndivdualtname = $this->request->getData()['inserIndivdualtname'][$i];
					$insertcompanyname = $this->request->getData()['insertcompanyname'][$i];
					$insertbuildersname = $this->request->getData()['insertbuildersname'][$i];
					$projectname = $this->request->getData()['projectname'][$i];
					$datenew = date('Y-m-d',strtotime($this->request->getData()['date'][$i]));
					$date = date('d/m/Y',strtotime($this->request->getData()['date'][$i]));
					$insertname =$this->request->getData()['insertname'][$i]; 
					
					$mobile =$this->request->getData()['mobile'][$i]; 
					$landline =$this->request->getData()['landline'][$i]; 
					
					$ifesxistmail = $this->EoiMailer->find()->where(['insertbuilderemal' => $insertbuildersname])->first();
					if(empty($ifesxistmail)){
						if(!empty($this->request->getData()['senderemail'][$i])){
							$senderemail = $this->request->getData()['senderemail'][$i]; 
						}else{
							//$senderemail = 'sales@durotechindustries.com.au'; 
						}
						if(!empty($this->request->getData()['subject'][$i])){
							$subject = $this->request->getData()['subject'][$i]; 
						}else{
							$subject = 'Durotech Industries :- Waterproofing and Epoxy Flooring'; 
						}
											
						//$url = SITEURL.'cws/sendemail.php';
						$url = SITEURL.'cws/sendnewemail.php';
						$fields = array(
							'mailer_id' => urlencode($mailer_id),
							'inserIndivdualtname' => urlencode($inserIndivdualtname),
							'insertcompanyname' => urlencode($insertcompanyname),
							'insertbuildersname' => urlencode($insertbuildersname),
							'projectname' => urlencode($projectname),
							'date' => urlencode($date),
							'insertname' => urlencode($insertname),
							'subject' => urlencode($subject),
							'senderemail' => urlencode($senderemail)
						);
										
						$fields_string = '';
						//url-ify the data for the POST
						foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
						rtrim($fields_string, '&');
						
						$fields_string = rtrim($fields_string, '&');
						$url = SITEURL.'cws/sendnewemail.php?'.$fields_string;			
						
						$arrContextOptions=array(
							"ssl"=>array(
								"verify_peer"=>false,
								"verify_peer_name"=>false,
							),
						);  
						$result = file_get_contents($url, false, stream_context_create($arrContextOptions));
						
						/* //open connection
						$ch = curl_init();
						//set the url, number of POST vars, POST data
						curl_setopt($ch,CURLOPT_URL, $url);
						curl_setopt($ch,CURLOPT_POST, count($fields));
						curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
						//execute post
						$result = curl_exec($ch);

						//close connection
						curl_close($ch); */					
						$Mailerinsert = [
							'mailer_id' => $mailer_id,
							'user_id' => $user_id,
							'inserindivdualname' => $inserIndivdualtname,
							'insertcompanyname' => $insertcompanyname,
							'insertbuilderemal' => $insertbuildersname,
							'date' => $datenew,
							'projectname' => $projectname,
							'insertname' => $insertname,
							'subject' => $subject,
							'sender_email' => $senderemail,
							'mobile' => $mobile,
							'client_requested' => $client_requested,
							'landlineno' => $landline,
							'created' => date('Y-m-d H:i:s'),
							'status' => 1,
						];
						$entity = $this->EoiMailer->newEntity($Mailerinsert);
						$this->EoiMailer->save($entity);		
				}else{
					$this->Flash->error('This email id already exists.');
				}	
				}
		
			}	
			$this->Flash->success('Emailer sent successfully');
			return $this->redirect(array('action' => 'eoi'));
		}
		
	}

	/** CamelCase alias for route /admin/mailers/editsend/:id (dispatcher may expect adminEditsend) */
	public function adminEditsend($id = null)
	{
		return $this->admin_editsend($id);
	}

	public function admin_editsend($id=null) {

		$this->viewBuilder()->setLayout('admin_layout');
		$this->set('title_for_layout',SITENAME.' DuroEzy Specification Mailer');
		$this->checkAdminSession(); 
		$user_id=$this->request->getSession()->read('User.id');
		if (!empty($this->request->getData()))
		{
			$isDraft = isset($this->request->getData()['save_draft']);

			
			$form_type = $this->request->getData()['form_type'];
			
			$exp =  explode('/',$this->request->getData()['date']); 
			$name = $this->request->getData()['name'];
			$email = $this->request->getData()['email'];
			$company = $this->request->getData()['company'];
			$address = $this->request->getData()['address'];
			$specification = $this->request->getData()['specification'];
			//$date = date('Y-m-d',strtotime($this->request->getData()['date']));
			if(count($exp) == 3)
			{
				$date = $exp[2].'-'.$exp[1].'-'.$exp[0];
			}else{
				$date = $this->request->getData()['date'];
			}
			$type = $this->request->getData()['type'];
			$subject = $this->request->getData()['subject'];
			//$mft = $this->request->getData()['mft'];
			//$warranty_period = $this->request->getData()['warranty_period'];
			//echo $date; die();
			isset($this->request->getData()['use_area'])? $use_area = $this->request->getData()['use_area'] : $use_area =0;
			
			if($form_type == 0){
				$inserty['Mailer']['id'] = $id;
				$tracknumber = $this->request->getData()['tracknumber'];
			}else{
				$refrmon = array('01'=>'a','02'=>'b','03'=>'c','04'=>'d','05'=>'e','06'=>'f','07'=>'g','08'=>'h','09'=>'i','10'=>'j','11'=>'k','12'=>'l');
				$mailerid = (int)$this->Mailer->find()->where(['type' => 3])->count();
				$id = (string)($mailerid + 1);
				
				$yr = date('y');
				$mm = date('m');
				if(strlen($id) == 1){
					$code = '00'.$id;
				}else if(strlen($id) == 2){
					$code = '0'.$id;
				}else{
					$code = $id;
				}			
				$tracknumber = 'DTSPEC '.$yr.'-'.$mm.'-'.$code; 
			}

			//new_code deepak

        // Handle file upload (using CakePHP convention)

        $uploadPath = WWW_ROOT . 'uploads' . DS . 'datasheets' . DS;

        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        if (!empty($this->request->getData()['Mailer']['datasheet_pdf']['tmp_name'])) {

            $file = $this->request->getData()['Mailer']['datasheet_pdf'];

            // Remove old file if exists
            try {
                $existing = $this->Mailer->get((int)$id);
                if ($existing->pdf_attachment) {
                    $oldFile = WWW_ROOT . str_replace('/', DS, $existing->pdf_attachment);
                    if (file_exists($oldFile)) {
                        unlink($oldFile);
                    }
                }
            } catch (\Cake\Datasource\Exception\RecordNotFoundException $e) {
                // ignore
            }

            $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
            $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9_\-\.]/', '_', $file['name']);
            $fullPath = $uploadPath . $filename;

            if (move_uploaded_file($file['tmp_name'], $fullPath)) {
                $inserty['Mailer']['pdf_attachment'] = 'uploads/datasheets/' . $filename;
            } else {
                $this->Flash->error('Failed to upload file.');
                return $this->redirect(\Cake\Routing\Router::url(['controller' => 'Mailers', 'action' => 'admin_index'], true));
            }
        }

			$inserty['Mailer']['admin_id'] = $user_id;
			$inserty['Mailer']['name'] = $name;
			$inserty['Mailer']['tracknumber'] = $tracknumber;
			$inserty['Mailer']['address'] = $address;
			$inserty['Mailer']['specification'] = $specification;
			$inserty['Mailer']['date'] = $date;
			$inserty['Mailer']['email'] = $email;
			$inserty['Mailer']['company'] = $company;
			$inserty['Mailer']['type'] = $type;
			$inserty['Mailer']['subject'] = $subject;
			$inserty['Mailer']['use_area'] = $use_area;
			$inserty['Mailer']['save_status'] = $isDraft ? 'draft' : 'submitted';

			$inserty['Mailer']['created'] = date('Y-m-d H:i:s');

			if ($form_type == 0) {
				$mailerEntity = $this->Mailer->get((int)$id);
				$mailerEntity = $this->Mailer->patchEntity($mailerEntity, $inserty['Mailer']);
			} else {
				$mailerEntity = $this->Mailer->newEntity($inserty['Mailer']);
			}
			if ($this->Mailer->save($mailerEntity)) {
				$lastinsertId = $mailerEntity->id;

				$this->MailerComment->deleteAll(['mailer_id' => $lastinsertId]);
				if (!empty($this->request->getData()['comment'])) {
					foreach ($this->request->getData()['comment'] as $comment) {
						$ce = $this->MailerComment->newEntity([
							'mailer_id' => $lastinsertId,
							'use_area' => 1,
							'comment' => $comment,
						]);
						$this->MailerComment->save($ce);
					}
				}

				$this->SpecUsearea->deleteAll(['mailer_id' => $lastinsertId]);
				if (!empty($this->request->getData()['product'])) {
					$data = $this->request->getData();
					foreach ($data['product'] as $key => $prodt) {
						$title = isset($data['title'][$data['types'][$key]]) ? $data['title'][$data['types'][$key]] : '';
						$se = $this->SpecUsearea->newEntity([
							'mailer_id' => $lastinsertId,
							'title' => $title,
							'product' => $prodt,
							'types' => $data['types'][$key] ?? null,
							'serial' => $data['serial'][$key] ?? '',
							'coverage' => $data['coverage'][$key] ?? '',
							'Warranty' => $data['Warranty'][$key] ?? '',
							'coverage_by_pack' => $data['coverage_by_pack'][$key] ?? '',
						]);
						$this->SpecUsearea->save($se);
					}
				}

				if ($isDraft) {
					$this->Flash->success('Draft saved successfully.');
					return $this->redirect(Router::url(['controller' => 'Mailers', 'action' => 'admin_index'], true));
				}

				$pdfname = $lastinsertId . '-' . $tracknumber;
				$dateVal = $this->request->getData('date');
				$fields = array(
					'tracknumber' => urlencode((string) $tracknumber),
					'mailer_id' => urlencode((string) $lastinsertId),
					'name' => urlencode((string) $name),
					'email' => urlencode((string) $email),
					'address' => urlencode((string) $address),
					'company' => urlencode((string) $company),
					'specification' => urlencode((string) $specification),
					'date' => urlencode((string) $dateVal),
					'subject' => urlencode((string) $subject),
					'type' => urlencode((string) $type),
					'pdfname' => urlencode((string) $pdfname),
					'use_area' => urlencode((string) $use_area),
				);

				$fields_string = '';
				foreach ($fields as $key => $value) {
					$fields_string .= $key . '=' . $value . '&';
				}
				$fields_string = rtrim($fields_string, '&');
				if ($this->request->getData('spectype') == 1) {
					$url = SITEURL . 'dompdf/generatepdf.php?' . $fields_string;
				} else {
					$url = SITEURL . 'dompdf/generatewithoutpdf.php?' . $fields_string;
				}
				$arrContextOptions = array(
					"ssl"=>array(
						"verify_peer"=>false,
						"verify_peer_name"=>false,
					),
				);  
				
				$response = file_get_contents($url, false, stream_context_create($arrContextOptions));


				//$result = file_get_contents($url);
				
				$this->Flash->success('PDF file updated successfully.');
				return $this->redirect(Router::url(['controller' => 'Mailers', 'action' => 'admin_index'], true));
			}
		}

		// CakePHP 3: associations are on MailerTable; load with contain (no bindModel)
		$mailer = $this->Mailer->get((int)$id, ['contain' => ['MailerComment', 'SpecUsearea']]);
		$MailerArr = [
			'Mailer' => $mailer->toArray(),
			'MailerComment' => [],
			'SpecUsearea' => [],
		];
		foreach ($mailer->mailer_comment ?? [] as $c) {
			$MailerArr['MailerComment'][] = $c->toArray();
		}
		foreach ($mailer->spec_usearea ?? [] as $s) {
			$MailerArr['SpecUsearea'][] = $s->toArray();
		}

		$product = array();
		if (!empty($MailerArr['SpecUsearea'])) {
			foreach($MailerArr['SpecUsearea'] as $SpecUseareas){
				$SpecUsearea['title'] = $SpecUseareas['title'];
				$SpecUsearea['product'] = $SpecUseareas['product'];
				$SpecUsearea['coverage'] = $SpecUseareas['coverage'];
				$SpecUsearea['coverage_by_pack'] = $SpecUseareas['coverage_by_pack'];
				$SpecUsearea['serial'] = $SpecUseareas['serial'];
				$SpecUsearea['Warranty'] = $SpecUseareas['Warranty'];
				$product[$SpecUseareas['types']][] = $SpecUsearea;
			}
		}
		
		$refernce = $MailerArr['Mailer']['tracknumber'];
		$this->set('product',$product);
		$this->set('refernce',$refernce);
		$this->set('MailerArr',$MailerArr);
		
		
	}
	
	public function priceListLog(){		
		
		$this->viewBuilder()->setLayout('staff_inner_layout');
		$this->set('title_for_layout',SITENAME.' Price List Logs');		
		$this->checkSatffSession(); 
		$customer_id=$this->request->getSession()->read('Customer.id');

		$query = $this->NewPriceListLog->find()
			->where(['NewPriceListLog.user_id' => $customer_id])
			->orderDesc('NewPriceListLog.id');
		$result = $this->paginate($query, ['limit' => 25]);
		$mailers = [];
		foreach ($result as $row) {
			$mailers[] = ['NewPriceListLog' => $row->toArray()];
		}
		$this->set('mailers', $mailers);		
	}
	
	public function priceListMailers(){
	
		$this->viewBuilder()->setLayout('staff_inner_layout');
		$this->set('title_for_layout',SITENAME.' Price List Logs');		
		$this->checkSatffSession(); 
		$customer_id=$this->request->getSession()->read('Customer.id');
		
			if (!empty($this->request->getData())) {
				
				
				
			$mailerid = (int)$this->NewPriceListLog->find()->count();
			$id = $mailerid + 1;
			$yr = date('y');
			$mm = date('m');
			$code = str_pad((string)$id, 3, '0', STR_PAD_LEFT);
			$reference_id = 'DTNPL ' . $yr . '-' . $mm . '-' . $code;

			$data = $this->request->getData('NewPriceListLog');
			$name = $data['name'] ?? '';
			$email = $data['email'] ?? '';
			$subject = $data['subject'] ?? '';
			$message = $data['message'] ?? '';
			$date = $data['date'] ?? date('Y-m-d');

			$entity = $this->NewPriceListLog->newEntity([
				'user_id' => $customer_id,
				'email' => $email,
				'name' => $name,
				'subject' => $subject,
				'message' => $message,
				'reference_id' => $reference_id,
				'date' => $date,
				'status' => 1,
			]);
			if ($this->NewPriceListLog->save($entity)) {
				$lastinsertId = $entity->id;
				$url = (defined('SITEURL') ? SITEURL : '') . 'cws/newpricelog.php?lastinsertId=' . urlencode((string)$lastinsertId);
				@file_get_contents($url);
				$this->Flash->success('Mailer sent successfully.');
				return $this->redirect(['action' => 'priceListLog']);
			}
		}	
	}	
	
	/** CamelCase alias for /admin/mailers/editv/:id dispatcher compatibility */
	public function adminEditv($id = null)
	{
		return $this->admin_editv($id);
	}

	public function admin_editv($id=null) {
		
		
		$this->viewBuilder()->setLayout('admin_layout');
		$this->set('title_for_layout',SITENAME.' DuroEzy Specification Mailer');
		$this->checkAdminSession(); 
		$user_id=$this->request->getSession()->read('User.id');
		if (!empty($this->request->getData())) 
		{
			
			// echo '<pre>';
			// print_r($this->request->getData());
			// die();		
			$form_type = $this->request->getData()['form_type'];
			
			$exp =  explode('/',$this->request->getData()['date']); 
			$name = $this->request->getData()['name'];
			$email = $this->request->getData()['email'];
			$company = $this->request->getData()['company'];
			$address = $this->request->getData()['address'];
			$specification = $this->request->getData()['specification'];
			//$date = date('Y-m-d',strtotime($this->request->getData()['date']));
			if(count($exp) == 3)
			{
				$date = $exp[2].'-'.$exp[1].'-'.$exp[0];
			}else{
				$date = $this->request->getData()['date'];
			}
			$type = $this->request->getData()['type'];
			$subject = $this->request->getData()['subject'];
			//$mft = $this->request->getData()['mft'];
			//$warranty_period = $this->request->getData()['warranty_period'];
			//echo $date; die();
			isset($this->request->getData()['use_area'])? $use_area = $this->request->getData()['use_area'] : $use_area =0;
			
			if($form_type == 0){
				$inserty['Mailer']['id'] = $id;
				$tracknumber = $this->request->getData()['tracknumber'];
			}else{
				$refrmon = array('01'=>'a','02'=>'b','03'=>'c','04'=>'d','05'=>'e','06'=>'f','07'=>'g','08'=>'h','09'=>'i','10'=>'j','11'=>'k','12'=>'l');
				$mailerid = (int)$this->Mailer->find()->where(['type' => 3])->count();
				$id = (string)($mailerid + 1);
				
				$yr = date('y');
				$mm = date('m');
				if(strlen($id) == 1){
					$code = '00'.$id;
				}else if(strlen($id) == 2){
					$code = '0'.$id;
				}else{
					$code = $id;
				}			
				$tracknumber = 'DTSPEC '.$yr.'-'.$mm.'-'.$code; 
			}
			
			$inserty = [];
			$inserty['admin_id'] = $user_id;
			$inserty['name'] = $name;
			$inserty['tracknumber'] = $tracknumber;
			$inserty['address'] = $address;
			$inserty['specification'] = $specification;
			$inserty['date'] = $date;
			$inserty['email'] = $email;
			$inserty['company'] = $company;
			$inserty['type'] = $type;
			$inserty['subject'] = $subject;
			$inserty['use_area'] = $use_area;
			$inserty['created'] = date('Y-m-d H:i:s');

			if($form_type == 0){
				$mailerEntity = $this->Mailer->get((int)$id);
				$mailerEntity = $this->Mailer->patchEntity($mailerEntity, $inserty);
			}else{
				$mailerEntity = $this->Mailer->newEntity($inserty);
			}
			
			if($this->Mailer->save($mailerEntity)){				
				$lastinsertId = (int)$mailerEntity->id;
							
				// delete older mailer comments
				$this->MailerComment->deleteAll(['mailer_id' => $lastinsertId]);
				if(!empty($this->request->getData()['comment'])){
					foreach($this->request->getData()['comment'] as $comment){
						$commentEntity = $this->MailerComment->newEntity([
							'mailer_id' => $lastinsertId,
							'use_area' => 1,
							'comment' => $comment,
						]);
						$this->MailerComment->save($commentEntity);
					}
				}
				
				
				$this->SpecUsearea->deleteAll(['mailer_id' => $lastinsertId]);
				if(!empty($this->request->getData()['product'])){
					foreach($this->request->getData()['product'] as $key=>$prodt){
						
						isset($this->request->getData()['title'][$this->request->getData()['types'][$key]])? $title = $this->request->getData()['title'][$this->request->getData()['types'][$key]] :  $title = '';
						$specEntity = $this->SpecUsearea->newEntity([
							'mailer_id' => $lastinsertId,
							'title' => $title,
							'product' => $prodt,
							'types' => $this->request->getData()['types'][$key] ?? null,
							'serial' => $this->request->getData()['serial'][$key] ?? '',
							'coverage' => $this->request->getData()['coverage'][$key] ?? '',
							'description' => $this->request->getData()['description'][$key] ?? '',
							'coverage_by_pack' => $this->request->getData()['coverage_by_pack'][$key] ?? '',
						]);
						$this->SpecUsearea->save($specEntity);
					}
				}
				
				
				$pdfname = $lastinsertId.'-'.$tracknumber;
				$fields = array(
					'tracknumber' => urlencode((string)$tracknumber),
					'mailer_id' => urlencode((string)$lastinsertId),
					'name' => urlencode($name),
					'email' => urlencode($email),				
					'address' => urlencode($address),
					'company' => urlencode($company),
					'specification' => urlencode($specification),
					'date' => urlencode($this->request->getData()['date']),
					'subject' => urlencode($subject),
					'type' => urlencode((string)$type),
					'pdfname' => urlencode($pdfname),					
					'use_area' => urlencode((string)$use_area),					
					//'mft' => urlencode($mft),					
					//'warranty_period' => urlencode($warranty_period),					
				);		
							
							
				$fields_string = '';
				//url-ify the data for the POST
				foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }			
				$fields_string = rtrim($fields_string, '&');
				$url = SITEURL.'dompdf/generatepdf_v1.php?'.$fields_string;
				
				$arrContextOptions=array(
					"ssl"=>array(
						"verify_peer"=>false,
						"verify_peer_name"=>false,
					),
				);  
				//echo $url; die();
				//echo $url; die();
				$response = file_get_contents($url, false, stream_context_create($arrContextOptions));


				//$result = file_get_contents($url);
				
				$this->Flash->success('PDF file updated successfully.');
				return $this->redirect(array('action' => 'spec_index'));
			}
		}		
		
		$mailerEntity = $this->Mailer->get((int)$id, [
			'contain' => ['MailerComment', 'SpecUsearea']
		]);
		$MailerArr = [
			'Mailer' => $mailerEntity->toArray(),
			'MailerComment' => [],
			'SpecUsearea' => [],
		];
		if (!empty($mailerEntity->mailer_comment)) {
			foreach ($mailerEntity->mailer_comment as $commentEntity) {
				$MailerArr['MailerComment'][] = $commentEntity->toArray();
			}
		}
		if (!empty($mailerEntity->spec_usearea)) {
			foreach ($mailerEntity->spec_usearea as $specEntity) {
				$MailerArr['SpecUsearea'][] = $specEntity->toArray();
			}
		}
		// echo '<pre>';
		// print_r($MailerArr);
		// die();
		$product =array();
		if(!empty($MailerArr['SpecUsearea'])){
			foreach($MailerArr['SpecUsearea'] as $SpecUseareas){
				$SpecUsearea['title'] = $SpecUseareas['title'];
				$SpecUsearea['product'] = $SpecUseareas['product'];
				$SpecUsearea['coverage'] = $SpecUseareas['coverage'];
				$SpecUsearea['coverage_by_pack'] = $SpecUseareas['coverage_by_pack'];
				$SpecUsearea['serial'] = $SpecUseareas['serial'];
				$SpecUsearea['Warranty'] = $SpecUseareas['Warranty'];
				$SpecUsearea['description'] = $SpecUseareas['description'];
				$product[$SpecUseareas['types']][] = $SpecUsearea;
			}
		}
		
		$refernce = $MailerArr['Mailer']['tracknumber'];
		$this->set('product',$product);
		$this->set('refernce',$refernce);
		$this->set('MailerArr',$MailerArr);
		
		
	}


	/** CamelCase alias for /admin/mailers/review_edit/:id */
	public function adminReviewEdit($id = null)
	{
		return $this->admin_review_edit($id);
	}

		public function admin_review_edit($id=null) {
		
		
		$this->viewBuilder()->setLayout('admin_layout');
		$this->set('title_for_layout',SITENAME.' DuroEzy Specification Mailer');
		$this->checkAdminSession(); 
		$user_id=$this->request->getSession()->read('User.id');
		if (!empty($this->request->getData())) 
		{
			
			// echo '<pre>';
			// print_r($this->request->getData());
			// die();		
			$form_type = $this->request->getData()['form_type'];
			
			$exp =  explode('/',$this->request->getData()['date']); 
			$name = $this->request->getData()['name'];
			$email = $this->request->getData()['email'];
			$company = $this->request->getData()['company'];
			$address = $this->request->getData()['address'];
			$specification = $this->request->getData()['specification'];
			//$date = date('Y-m-d',strtotime($this->request->getData()['date']));
			if(count($exp) == 3)
			{
				$date = $exp[2].'-'.$exp[1].'-'.$exp[0];
			}else{
				$date = $this->request->getData()['date'];
			}
			$type = $this->request->getData()['type'];
			$subject = $this->request->getData()['subject'];
			//$mft = $this->request->getData()['mft'];
			//$warranty_period = $this->request->getData()['warranty_period'];
			//echo $date; die();
			isset($this->request->getData()['use_area'])? $use_area = $this->request->getData()['use_area'] : $use_area =0;
			
			if($form_type == 0){
				$inserty['Mailer']['id'] = $id;
				$tracknumber = $this->request->getData()['tracknumber'];
			}else{
				$refrmon = array('01'=>'a','02'=>'b','03'=>'c','04'=>'d','05'=>'e','06'=>'f','07'=>'g','08'=>'h','09'=>'i','10'=>'j','11'=>'k','12'=>'l');
				$mailerid = (int)$this->Mailer->find()->where(['type' => 3])->count();
				$id = (string)($mailerid + 1);
				
				$yr = date('y');
				$mm = date('m');
				if(strlen($id) == 1){
					$code = '00'.$id;
				}else if(strlen($id) == 2){
					$code = '0'.$id;
				}else{
					$code = $id;
				}			
				$tracknumber = 'DTSPEC '.$yr.'-'.$mm.'-'.$code; 
			}
			
			$inserty = [];
			$inserty['admin_id'] = $user_id;
			$inserty['name'] = $name;
			$inserty['tracknumber'] = $tracknumber;
			$inserty['address'] = $address;
			$inserty['specification'] = $specification;
			$inserty['date'] = $date;
			$inserty['email'] = $email;
			$inserty['company'] = $company;
			$inserty['type'] = $type;
			$inserty['subject'] = $subject;
			$inserty['use_area'] = $use_area;
			$inserty['created'] = date('Y-m-d H:i:s');
			$inserty['is_review'] = isset($this->request->getData()['Mailer']['is_review']) ? $this->request->getData()['Mailer']['is_review'] : 0;

			if($form_type == 0){
				$mailerEntity = $this->Mailer->get((int)$id);
				$mailerEntity = $this->Mailer->patchEntity($mailerEntity, $inserty);
			}else{
				$mailerEntity = $this->Mailer->newEntity($inserty);
			}

			if($this->Mailer->save($mailerEntity)){				
				$lastinsertId = (int)$mailerEntity->id;
							
				// delete older mailer comments
				$this->MailerComment->deleteAll(['mailer_id' => $lastinsertId]);
				if(!empty($this->request->getData()['comment'])){
					foreach($this->request->getData()['comment'] as $comment){
						$commentEntity = $this->MailerComment->newEntity([
							'mailer_id' => $lastinsertId,
							'use_area' => 1,
							'comment' => $comment,
						]);
						$this->MailerComment->save($commentEntity);
					}
				}
				
				
				$this->SpecUsearea->deleteAll(['mailer_id' => $lastinsertId]);
				if(!empty($this->request->getData()['product'])){
					foreach($this->request->getData()['product'] as $key=>$prodt){
						
						isset($this->request->getData()['title'][$this->request->getData()['types'][$key]])? $title = $this->request->getData()['title'][$this->request->getData()['types'][$key]] :  $title = '';
						$specEntity = $this->SpecUsearea->newEntity([
							'mailer_id' => $lastinsertId,
							'title' => $title,
							'product' => $prodt,
							'types' => $this->request->getData()['types'][$key] ?? null,
							'serial' => $this->request->getData()['serial'][$key] ?? '',
							'coverage' => $this->request->getData()['coverage'][$key] ?? '',
							'Warranty' => $this->request->getData()['Warranty'][$key] ?? '',
							'coverage_by_pack' => $this->request->getData()['coverage_by_pack'][$key] ?? '',
						]);
						$this->SpecUsearea->save($specEntity);
					}
				}
				
				
				$pdfname = $lastinsertId.'-'.$tracknumber;
				$fields = array(
					'tracknumber' => urlencode($tracknumber),
					'mailer_id' => urlencode((string)$lastinsertId),
					'name' => urlencode((string)$name),
					'email' => urlencode((string)$email),				
					'address' => urlencode((string)$address),
					'company' => urlencode((string)$company),
					'specification' => urlencode((string)$specification),
					'date' => urlencode((string)$this->request->getData()['date']),
					'subject' => urlencode((string)$subject),
					'type' => urlencode((string)$type),
					'pdfname' => urlencode((string)$pdfname),					
					'use_area' => urlencode((string)$use_area),					
					//'mft' => urlencode($mft),					
					//'warranty_period' => urlencode($warranty_period),					
				);		
							
							
				$fields_string = '';
				//url-ify the data for the POST
				foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }			
				$fields_string = rtrim($fields_string, '&');
				if($this->request->getData()['spectype'] == 1)
				{
					$url = SITEURL.'dompdf/generatepdf.php?'.$fields_string;	
				}else{
					$url = SITEURL.'dompdf/generatewithoutpdf.php?'.$fields_string;	
				}
				
				$arrContextOptions=array(
					"ssl"=>array(
						"verify_peer"=>false,
						"verify_peer_name"=>false,
					),
				);  
				//echo $url; die();
				//echo $url; die();
				$response = file_get_contents($url, false, stream_context_create($arrContextOptions));
				$pdfData = json_decode((string)$response, true);
				if (is_array($pdfData) && !empty($pdfData['success'])) {
					$pdfPath = $pdfData['path'] ?? ('dompdf/' . ($pdfData['filename'] ?? ''));
					if (!empty($pdfPath)) {
						$mailerEntity->pdf_attachment = (string)$pdfPath;
						$this->Mailer->save($mailerEntity);
					}
				}
				
				$this->Flash->success('Review saved and PDF updated successfully.');
				return $this->redirect(array('action' => 'admin_emp_spec_index'));
			}
		}		
		
		$mailerEntity = $this->Mailer->get((int)$id, [
			'contain' => ['MailerComment', 'SpecUsearea']
		]);
		$MailerArr = [
			'Mailer' => $mailerEntity->toArray(),
			'MailerComment' => [],
			'SpecUsearea' => [],
		];
		if (!empty($mailerEntity->mailer_comment)) {
			foreach ($mailerEntity->mailer_comment as $commentEntity) {
				$MailerArr['MailerComment'][] = $commentEntity->toArray();
			}
		}
		if (!empty($mailerEntity->spec_usearea)) {
			foreach ($mailerEntity->spec_usearea as $specEntity) {
				$MailerArr['SpecUsearea'][] = $specEntity->toArray();
			}
		}
		// echo '<pre>';
		// print_r($MailerArr);
		// die();
		$product =array();
		if(!empty($MailerArr['SpecUsearea'])){
			foreach($MailerArr['SpecUsearea'] as $SpecUseareas){
				$SpecUsearea['title'] = $SpecUseareas['title'];
				$SpecUsearea['product'] = $SpecUseareas['product'];
				$SpecUsearea['coverage'] = $SpecUseareas['coverage'];
				$SpecUsearea['coverage_by_pack'] = $SpecUseareas['coverage_by_pack'];
				$SpecUsearea['serial'] = $SpecUseareas['serial'];
				$SpecUsearea['Warranty'] = $SpecUseareas['Warranty'];
				$SpecUsearea['description'] = $SpecUseareas['description'];
				$product[$SpecUseareas['types']][] = $SpecUsearea;
			}
		}
		
		$refernce = $MailerArr['Mailer']['tracknumber'];
		$this->set('product',$product);
		$this->set('refernce',$refernce);
		$this->set('MailerArr',$MailerArr);
		
		
	}
	
	/**
	 * CamelCase alias for CakePHP 3 dispatcher compatibility.
	 */
	public function adminSpecIndex()
	{
		return $this->admin_spec_index();
	}

	/**
	 * Non-admin aliases used by legacy redirects.
	 */
	public function specIndex()
	{
		return $this->admin_spec_index();
	}

	public function spec_index()
	{
		return $this->admin_spec_index();
	}

	public function admin_spec_index(){		
		
		$this->viewBuilder()->setLayout('admin_layout');
		$this->viewBuilder()->setTemplate('admin_spec_index');
		$this->set('title_for_layout',SITENAME.' DuroEzy Specification Mailer');		
		$this->checkAdminSession(); 
		$user_id=$this->request->getSession()->read('User.id');
		$query = $this->Mailer->find()
			->where(['Mailer.spec_v' => 1, 'Mailer.admin_id' => $user_id])
			->contain(['User'])
			->orderDesc('Mailer.id');
		$mailers = $this->paginate($query, ['limit' => 25]);

		$this->set('mailers', $mailers);		
	}

	/**
	 * Legacy compatibility aliases for links pointing to create_dwps without admin prefix.
	 */
	public function createDwps()
	{
		return $this->admin_create_dwps();
	}

	public function create_dwps()
	{
		return $this->admin_create_dwps();
	}

	/**
	 * CamelCase alias for CakePHP 3 dispatcher compatibility.
	 */
	public function adminCreateDwps()
	{
		return $this->admin_create_dwps();
	}
	
	public function admin_create_dwps() 
	{
		
		$this->viewBuilder()->setLayout('admin_layout');
		// Allow both admin_create_dwps and create_dwps aliases to render same template.
		$this->viewBuilder()->setTemplate('admin_create_dwps');
		$this->set('title_for_layout',SITENAME.' DuroEzy Specification');
		$this->checkAdminSession(); 
		$user_id=$this->request->getSession()->read('User.id');
		if (!empty($this->request->getData())) 
		{			
			$tracknumber = $this->request->getData()['tracknumber'];
			$name = $this->request->getData()['name'];
			$email = $this->request->getData()['email'];
			$company = $this->request->getData()['company'];
			$address = $this->request->getData()['address'];
			$specification = $this->request->getData()['specification'];
			$date = date('Y-m-d',strtotime($this->request->getData()['date']));
			$type = $this->request->getData()['type'];
			$subject = $this->request->getData()['subject'];
			//$mft = $this->request->getData()['mft'];
			//$warranty_period = $this->request->getData()['warranty_period'];
			isset($this->request->getData()['use_area'])? $use_area = $this->request->getData()['use_area'] : $use_area =1;
			
			$inserty['Mailer']['admin_id'] = $user_id;
			$inserty['Mailer']['name'] = $name;
			$inserty['Mailer']['tracknumber'] = $tracknumber;
			$inserty['Mailer']['address'] = $address;
			$inserty['Mailer']['specification'] = $specification;
			$inserty['Mailer']['date'] = $date;
			$inserty['Mailer']['email'] = $email;
			$inserty['Mailer']['company'] = $company;
			$inserty['Mailer']['type'] = $type;
			$inserty['Mailer']['subject'] = $subject;
			$inserty['Mailer']['use_area'] = $use_area;
			//$inserty['Mailer']['mft'] = $mft;
			//$inserty['Mailer']['warranty_period'] = $warranty_period;
			$inserty['created'] = date('Y-m-d H:i:s');
			$inserty['spec_v'] = 1;
			
			$mailerEntity = $this->Mailer->newEntity($inserty);
			if($this->Mailer->save($mailerEntity))
			{
				$lastinsertId = (int)$mailerEntity->id;
				
				if(!empty($this->request->getData()['comment'])){
					foreach($this->request->getData()['comment'] as $comment){
						$commentEntity = $this->MailerComment->newEntity([
							'mailer_id' => $lastinsertId,
							'use_area' => 1,
							'comment' => $comment,
						]);
						$this->MailerComment->save($commentEntity);
					}
				}
				
				if(!empty($this->request->getData()['product']))
				{
					foreach($this->request->getData()['product'] as $key=>$prodt)
					{
						
						
						isset($this->request->getData()['dwps'][$this->request->getData()['types'][$key]])? $dwps = $this->request->getData()['dwps'][$this->request->getData()['types'][$key]] :  $dwps = '';
						if(!empty($dwps))
						{
							isset($this->request->getData()['title'][$this->request->getData()['types'][$key]])? $title = $this->request->getData()['title'][$this->request->getData()['types'][$key]] :  $title = '';
							$insert = [];
							$insert['mailer_id'] = $lastinsertId;
							$insert['use_area'] = 1;
							$insert['title'] = $title;
							$insert['product'] = $this->request->getData()['product'][$key];
							$insert['types'] = $this->request->getData()['types'][$key];
							$insert['serial'] = $this->request->getData()['serial'][$key];
							$insert['coverage'] = $this->request->getData()['coverage'][$key];
							$insert['description'] = $this->request->getData()['description'][$key];
							//$insert['SpecUsearea']['Warranty'] = $this->request->getData()['Warranty'][$key];
							$insert['coverage_by_pack'] = $this->request->getData()['coverage_by_pack'][$key];
							
							// echo '<pre>';
							// print_r($insert);
							// echo '</pre>';
							
							$specEntity = $this->SpecUsearea->newEntity($insert);
							$this->SpecUsearea->save($specEntity);
						}
					}
				}
				
				$pdfname = $lastinsertId.'-'.$tracknumber;
				$fields = array(
					'tracknumber' => urlencode((string)$tracknumber),
					'mailer_id' => urlencode((string)$lastinsertId),
					'name' => urlencode((string)$name),
					'email' => urlencode((string)$email),				
					'address' => urlencode((string)$address),
					'company' => urlencode((string)$company),
					'specification' => urlencode((string)$specification),
					'date' => urlencode((string)$this->request->getData()['date']),
					'subject' => urlencode((string)$subject),
					'type' => urlencode((string)$type),
					'pdfname' => urlencode((string)$pdfname),					
					//'mft' => urlencode($mft),					
					//'warranty_period' => urlencode($warranty_period),					
					'use_area' => urlencode((string)$use_area),					
				);		
																
				$fields_string = '';
				//url-ify the data for the POST
				foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }			
				$fields_string = rtrim($fields_string, '&');
				$url = SITEURL.'dompdf/generatepdf_v1.php?'.$fields_string;	
				//echo $url; die();
				$arrContextOptions=array(
					"ssl"=>array(
						"verify_peer"=>false,
						"verify_peer_name"=>false,
					),
				);  
				$result = file_get_contents($url, false, stream_context_create($arrContextOptions));
				$pdfPath = 'dompdf/' . $pdfname . '-V2.pdf';
				$absPdfPath = WWW_ROOT . str_replace('/', DS, $pdfPath);
				if (is_file($absPdfPath)) {
					$mailerEntity->pdf_attachment = $pdfPath;
				} else {
					// Fallback to stable generator if v1 file is not created.
					$fallbackUrl = SITEURL . 'dompdf/generatepdf.php?' . $fields_string;
					$fallbackResponse = @file_get_contents($fallbackUrl, false, stream_context_create($arrContextOptions));
					if ($fallbackResponse !== false) {
						$fallbackJson = json_decode((string)$fallbackResponse, true);
						if (is_array($fallbackJson) && !empty($fallbackJson['success'])) {
							$mailerEntity->pdf_attachment = (string)($fallbackJson['path'] ?? ('dompdf/' . ($fallbackJson['filename'] ?? '')));
						}
					}
				}
				$this->Mailer->save($mailerEntity);
				
				$this->Flash->success('PDF file generated successfully.');
				return $this->redirect(array('action' => 'spec_index'));
			}
		}
		$refrmon = array('01'=>'a','02'=>'b','03'=>'c','04'=>'d','05'=>'e','06'=>'f','07'=>'g','08'=>'h','09'=>'i','10'=>'j','11'=>'k','12'=>'l');
		$mailerid = (int)$this->Mailer->find()->where(['type' => 3])->count();
		$id = (string)($mailerid + 1);
		
		$yr = date('y');
		$mm = date('m');
		if(strlen($id) == 1){
			$code = '00'.$id;
		}else if(strlen($id) == 2){
			$code = '0'.$id;
		}else{
			$code = $id;
		}			
		$refernce = 'DTSPEC '.$yr.'-'.$mm.'-'.$code; 
		$this->set('refernce',$refernce);
		
		$SpecArr = $this->Spec->find('all');
		$this->set('SpecArr',$SpecArr);
		
		// echo '<pre>';
		// print_r($SpecArr);
		// die();
	}


		/** CamelCase alias for route /admin/mailers/editsend_v3 (dispatcher may expect adminEditsendV3) */
		public function adminEditsendV3($id = null)
		{
			return $this->admin_editsend_v3($id);
	}
	
	public function admin_editsend_v3($id=null) {
		
		$this->viewBuilder()->setLayout('admin_layout');
		$this->set('title_for_layout',SITENAME.' DuroEzy Specification Mailer');
		$this->checkAdminSession(); 
		$user_id=$this->request->getSession()->read('User.id');
		$returnPage = (int)$this->request->getQuery('page');
		if (!empty($this->request->getData())) 
		{
			$returnPage = isset($this->request->getData()['return_page']) ? (int)$this->request->getData()['return_page'] : $returnPage;
					
			// pr($this->request->getData());
			// die();

			
			$form_type = $this->request->getData()['form_type'];
			
			$exp =  explode('/',$this->request->getData()['date']); 
			$name = $this->request->getData()['name'];
			$email = $this->request->getData()['email'];
			$company = $this->request->getData()['company'];
			$address = $this->request->getData()['address'];
			$specification = $this->request->getData()['specification'];
			//$date = date('Y-m-d',strtotime($this->request->getData()['date']));
			if(count($exp) == 3)
			{
				$date = $exp[2].'-'.$exp[1].'-'.$exp[0];
			}else{
				$date = $this->request->getData()['date'];
			}
			$type = $this->request->getData()['type'];
			$subject = $this->request->getData()['subject'];
			//$mft = $this->request->getData()['mft'];
			//$warranty_period = $this->request->getData()['warranty_period'];
			//echo $date; die();
			isset($this->request->getData()['use_area'])? $use_area = $this->request->getData()['use_area'] : $use_area =0;
			
			if($form_type == 0){
				$inserty['Mailer']['id'] = $id;
				$tracknumber = $this->request->getData()['tracknumber'];
			}else{
				$refrmon = array('01'=>'a','02'=>'b','03'=>'c','04'=>'d','05'=>'e','06'=>'f','07'=>'g','08'=>'h','09'=>'i','10'=>'j','11'=>'k','12'=>'l');
				$mailerid = (int)$this->Mailer->find()->where(['type' => 3])->count();
				$id = (string)($mailerid + 1);
				
				$yr = date('y');
				$mm = date('m');
				if(strlen($id) == 1){
					$code = '00'.$id;
				}else if(strlen($id) == 2){
					$code = '0'.$id;
				}else{
					$code = $id;
				}			
				$tracknumber = 'DTSPEC '.$yr.'-'.$mm.'-'.$code; 
			}

			//new_code deepak

        // Handle file upload (using CakePHP convention)

        $uploadPath = WWW_ROOT . 'uploads' . DS . 'datasheets' . DS;

        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        if (!empty($this->request->getData()['Mailer']['datasheet_pdf']['tmp_name'])) {

            $file = $this->request->getData()['Mailer']['datasheet_pdf'];

            // Remove old file if exists
            $existing = $this->Mailer->findById($id);
            if (!empty($existing['Mailer']['pdf_attachment'])) {
                $oldFile = WWW_ROOT . str_replace('/', DS, $existing['Mailer']['pdf_attachment']);
                if (file_exists($oldFile)) {
                    unlink($oldFile);
                }
            }

            $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
            $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9_\-\.]/', '_', $file['name']);
            $fullPath = $uploadPath . $filename;

            if (move_uploaded_file($file['tmp_name'], $fullPath)) {
                $inserty['Mailer']['pdf_attachment'] = 'uploads/datasheets/' . $filename;
            } else {
                $this->Flash->error('Failed to upload file.');
                return $this->redirect(\Cake\Routing\Router::url(['controller' => 'Mailers', 'action' => 'admin_index_v3', '?' => ['page' => max(1, $returnPage)]], true));
            }
        }
			
			$inserty['Mailer']['admin_id'] = $user_id;
			$inserty['Mailer']['name'] = $name;
			$inserty['Mailer']['tracknumber'] = $tracknumber;
			$inserty['Mailer']['address'] = $address;
			$inserty['Mailer']['specification'] = $specification;
			$inserty['Mailer']['date'] = $date;
			$inserty['Mailer']['email'] = $email;
			$inserty['Mailer']['company'] = $company;
			$inserty['Mailer']['type'] = $type;
			$inserty['Mailer']['subject'] = $subject;
			$inserty['Mailer']['use_area'] = $use_area;			
			$inserty['Mailer']['created'] = date('Y-m-d H:i:s');

			// CakePHP 3: save() requires an Entity, not an array
			if ($form_type == 0) {
				$inserty['Mailer']['id'] = $id;
			}
			$mailerEntity = $this->Mailer->newEntity($inserty['Mailer']);
			if ($this->Mailer->save($mailerEntity)) {
				$lastinsertId = ($form_type == 0) ? (int)$id : $mailerEntity->id;

				$this->MailerComment->deleteAll(['mailer_id' => $lastinsertId]);
				if (!empty($this->request->getData()['comment'])) {
					foreach ($this->request->getData()['comment'] as $comment) {
						$commentEntity = $this->MailerComment->newEntity([
							'mailer_id' => $lastinsertId,
							'use_area' => 1,
							'comment' => $comment,
						]);
						$this->MailerComment->save($commentEntity);
					}
				}

				$this->SpecUsearea->deleteAll(['mailer_id' => $lastinsertId]);
				if (!empty($this->request->getData()['product'])) {
					$data = $this->request->getData();
					foreach ($data['product'] as $key => $prodt) {
						$title = isset($data['title'][$data['types'][$key]]) ? $data['title'][$data['types'][$key]] : '';
						$specEntity = $this->SpecUsearea->newEntity([
							'mailer_id' => $lastinsertId,
							'title' => $title,
							'product' => $prodt,
							'types' => $data['types'][$key] ?? null,
							'serial' => $data['serial'][$key] ?? '',
							'coverage' => $data['coverage'][$key] ?? '',
							'Warranty' => $data['Warranty'][$key] ?? '',
							'coverage_by_pack' => $data['coverage_by_pack'][$key] ?? '',
						]);
						$this->SpecUsearea->save($specEntity);
					}
				}

				$pdfname = $lastinsertId . '-' . $tracknumber;
				$dateVal = $this->request->getData('date');
				$fields = array(
					'tracknumber' => urlencode((string)$tracknumber),
					'mailer_id' => urlencode((string)$lastinsertId),
					'name' => urlencode((string)$name),
					'email' => urlencode((string)$email),
					'address' => urlencode((string)$address),
					'company' => urlencode((string)$company),
					'specification' => urlencode((string)$specification),
					'date' => urlencode((string)$dateVal),
					'subject' => urlencode((string)$subject),
					'type' => urlencode((string)$type),
					'pdfname' => urlencode((string)$pdfname),
					'use_area' => urlencode((string)$use_area),
				);		
							
							
				$fields_string = '';
				//url-ify the data for the POST
				foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }			
				$fields_string = rtrim($fields_string, '&');
				if($this->request->getData()['spectype'] == 1)
				{
					$url = SITEURL.'dompdf/generatepdf.php?'.$fields_string;	
				}else{
					$url = SITEURL.'dompdf/generatewithoutpdf.php?'.$fields_string;	
				}
				//echo $url; die();
				$arrContextOptions=array(
					"ssl"=>array(
						"verify_peer"=>false,
						"verify_peer_name"=>false,
					),
				);  
				//echo $url; die();
				//echo $url; die();
				$response = file_get_contents($url, false, stream_context_create($arrContextOptions));


				//$result = file_get_contents($url);
				
				$this->Flash->success('PDF file updated successfully.');
				return $this->redirect(\Cake\Routing\Router::url(['controller' => 'Mailers', 'action' => 'admin_index_v3', '?' => ['page' => max(1, $returnPage)]], true));
			}
		}		
		
		// CakePHP 3: associations defined in MailerTable; load with contain (no bindModel)
		$mailer = $this->Mailer->get((int)$id, ['contain' => ['MailerComment', 'SpecUsearea']]);
		$mailerData = $mailer->toArray();
		unset($mailerData['mailer_comment'], $mailerData['spec_usearea']);
		$MailerArr = [
			'Mailer' => $mailerData,
			'MailerComment' => [],
			'SpecUsearea' => [],
		];
		foreach ($mailer->mailer_comment ?? [] as $c) {
			$MailerArr['MailerComment'][] = $c->toArray();
		}
		foreach ($mailer->spec_usearea ?? [] as $s) {
			$MailerArr['SpecUsearea'][] = $s->toArray();
		}

		$product = [];
		if (!empty($MailerArr['SpecUsearea'])) {
			foreach ($MailerArr['SpecUsearea'] as $SpecUseareas) {
				$SpecUsearea = [
					'title' => $SpecUseareas['title'] ?? '',
					'product' => $SpecUseareas['product'] ?? '',
					'coverage' => $SpecUseareas['coverage'] ?? '',
					'coverage_by_pack' => $SpecUseareas['coverage_by_pack'] ?? '',
					'serial' => $SpecUseareas['serial'] ?? '',
					'Warranty' => $SpecUseareas['Warranty'] ?? '',
				];
				$types = $SpecUseareas['types'] ?? 0;
				$product[$types][] = $SpecUsearea;
			}
		}

		$refernce = $MailerArr['Mailer']['tracknumber'];
		$this->set('product', $product);
		$this->set('refernce', $refernce);
		$this->set('MailerArr', $MailerArr);
		$this->set('returnPage', max(1, $returnPage));
	}


		//14 june

	/** CamelCase alias for route /admin/mailers/specRequest_index */
	public function adminSpecRequestIndex()
	{
		return $this->admin_specRequest_index();
	}

	public function admin_specRequest_index() {

		$this->viewBuilder()->setLayout('admin_layout');
		$this->set('title_for_layout',SITENAME.' DuroEzy Specification Mailer');
		$this->checkAdminSession(); 


		$this->loadModel('DuroEasySpecRequest');
		$this->loadModel('DuroEasySpecUseArea');

		if ($this->request->is('post')) {
			$data = $this->request->getData();
			$data['DuroEasySpecRequest']['reference_id'] = 'REF' . time();
			$data['DuroEasySpecRequest']['status'] = 'pending';

			$this->DuroEasySpecRequest->create();
			if ($this->DuroEasySpecRequest->save($data)) {
				$requestId = $this->DuroEasySpecRequest->id;

				if (!empty($data['DuroEasySpecUseArea'])) {
					foreach ($data['DuroEasySpecUseArea'] as $area) {
						if (!empty($area['area_title'])) {
							$this->DuroEasySpecUseArea->create();
							$this->DuroEasySpecUseArea->save([
								'DuroEasySpecUseArea' => [
									'request_id' => $requestId,
									'area_title' => $area['area_title']
								]
							]);
						}
					}
				}

				$this->Flash->success('Spec request submitted successfully.');
				return $this->redirect(\Cake\Routing\Router::url(['controller' => 'Mailers', 'action' => 'admin_specRequest_index'], true));
			} else {
				$this->Flash->error('Failed to submit.');
			}
		}
	}

	/** CamelCase alias for route /admin/mailers/specRequest_approved */
	public function adminSpecRequestApproved()
	{
		return $this->admin_specRequest_approved();
	}

	public function admin_specRequest_approved(){

		$this->viewBuilder()->setLayout('admin_layout');
		$this->set('title_for_layout', SITENAME . ' DuroEzy Specification Mailer');
		$this->checkAdminSession();

		// CakePHP 3: associations (User, NappUser) are on MailerTable; use contain()
		$mailers = $this->Mailer->find()
			->where([
				'Mailer.spec_v' => 0,
				'Mailer.user_id !=' => 0,
				'Mailer.is_approved' => 1,
			])
			->contain(['User', 'NappUser'])
			->orderDesc('Mailer.id');

		$this->set('mailers', $mailers);
	}

	/** CamelCase alias for route /admin/mailers/specRequest_disapproved */
	public function adminSpecRequestDisapproved()
	{
		return $this->admin_specRequest_disapproved();
	}

	public function admin_specRequest_disapproved() {

		$this->viewBuilder()->setLayout('admin_layout');
		$this->set('title_for_layout', SITENAME . ' DuroEzy Specification Mailer');
		$this->checkAdminSession();

		// CakePHP 3: associations (User, NappUser) are on MailerTable; use contain()
		$mailers = $this->Mailer->find()
			->where([
				'Mailer.spec_v' => 0,
				'Mailer.user_id !=' => 0,
				'Mailer.is_approved' => 0,
			])
			->contain(['User', 'NappUser'])
			->orderDesc('Mailer.id');

		$this->set('mailers', $mailers);
	}

	/**
	 * CamelCase alias for URL dispatcher (CakePHP 3 looks for adminToggleApproval).
	 */
	public function adminToggleApproval($id = null)
	{
		return $this->admin_toggle_approval($id);
	}

	public function admin_toggle_approval($id = null)
	{
		$this->checkAdminSession();

		if (!$id || !$this->Mailer->exists(['id' => $id])) {
			$this->Flash->error('Invalid Mailer ID.');
			return $this->redirect($this->referer());
		}

		$user_id = $this->request->getSession()->read('User.id');

		$mailer = $this->Mailer->get($id);
		if (!$mailer) {
			$this->Flash->error('Mailer not found.');
			return $this->redirect($this->referer());
		}

		$currentApproved = (int)$mailer->is_approved;
		$newStatus = $currentApproved === 1 ? 0 : 1;

		if ($newStatus === 1 && empty($mailer->tracknumber)) {
			$count = (int)$this->Mailer->find()->where(['type' => 3])->count();
			$serial = $count + 1;
			$yr = date('y');
			$mm = date('m');
			$code = str_pad((string)$serial, 3, '0', STR_PAD_LEFT);
			$tracknumber = 'DTSPEC ' . $yr . '-' . $mm . '-' . $code;

			$mailer->is_approved = $newStatus;
			$mailer->admin_id = $user_id;
			$mailer->tracknumber = $tracknumber;
			$this->Mailer->save($mailer);
		} else {
			$mailer->is_approved = $newStatus;
			$this->Mailer->save($mailer);
		}

		$msg = $newStatus ? 'Specification Approved' : 'Specification Disapproved';
		$this->Flash->success($msg);

		return $this->redirect($this->referer());
	}


	// public function admin_emp_spec_index()
	// {
	// 	$this->viewBuilder()->setLayout('admin_layout');
	// 	$this->set('title_for_layout', SITENAME . ' DuroEzy Specification Mailer');

	// 	// Bind the Employee relation using employee_id
	// 	$this->Mailer->bindModel(array(
	// 		'belongsTo' => array(
	// 			'Employee' => array(
	// 				'className' => 'Employee',
	// 				'foreignKey' => 'employee_id',
	// 				'fields' => array('id', 'name', 'email')
	// 			)
	// 		)
	// 	));

	// 	$this->Mailer->recursive = 0;

	// 	$this->paginate = array(
	// 		'conditions' => array(
	// 			'Mailer.spec_v' => 0,
	// 			'Mailer.employee_id IS NOT NULL'  // Only mailers created by employees
	// 		),
	// 		'limit' => 25,
	// 		'order' => array('Mailer.id' => 'desc')
	// 	);

	// 	$mailers = $this->Paginator->paginate('Mailer');
		

	// 	$this->set('mailers', $mailers);
	// }


	/**
	 * CamelCase alias for CakePHP 3 dispatcher compatibility.
	 */
	public function adminEmpSpecIndex()
	{
		return $this->admin_emp_spec_index();
	}

		public function admin_emp_spec_index() 
	{
		$this->viewBuilder()->setLayout('admin_layout');
		$this->set('title_for_layout', SITENAME . ' DuroEzy Specification Mailer');
		$filter = (string)$this->request->getQuery('status', 'all');
		// DuroEzy specs (type=3): employee-submitted OR admin-created, exclude drafts
		$conditions = [
			'Mailer.type' => 3,
			'OR' => [
				['Mailer.employee_id IS NOT' => null],
				['Mailer.admin_id >' => 0],
			],
		];
		$schema = $this->Mailer->getSchema();
		if ($schema && $schema->getColumn('save_status')) {
			$conditions[] = ['OR' => [
				['Mailer.save_status IS' => null],
				['Mailer.save_status !=' => 'draft'],
			]];
		}
		$query = $this->Mailer->find()
			->where($conditions)
			->contain(['Employee'])
			->orderDesc('Mailer.id');

		if ($filter === 'approved') {
			$query->andWhere(['Mailer.status' => 1, 'Mailer.is_review' => 1]);
		} elseif ($filter === 'pending') {
			$query->andWhere(['OR' => [
				['Mailer.status' => 0],
				['Mailer.is_review' => 0],
			]]);
		}

		$mailers = $this->paginate($query, ['limit' => 25]);
		$this->set('mailers', $mailers);
		$this->set('filter', $filter); // pass to view
    }


	/** CamelCase alias for /admin/mailers/approve/:id */
	public function adminApprove($id = null)
	{
		return $this->admin_approve($id);
	}

	public function admin_approve($id = null) {
		$this->autoRender = false;

		$this->checkAdminSession(); 
		$user_id = $this->request->getSession()->read('User.id');

		if (!$id || !$this->Mailer->exists($id)) {
			$this->Flash->error('Invalid Mailer ID');
			return $this->redirect(array('action' => 'admin_emp_spec_index'));
		}

		$data = array(
			'Mailer' => array(
				'id' => $id,
				'status' => 1,
				'admin_id' => $user_id
			)
		);

		if ($this->Mailer->save($data)) {
			$this->Flash->success('Spec approved successfully.');
		} else {
			$this->Flash->error('Approval failed.');
		}

		return $this->redirect(array('action' => 'admin_emp_spec_index'));
	}


}
