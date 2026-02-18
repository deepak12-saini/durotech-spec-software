<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Exception\NotFoundException;

/**
 * CaseStudies Controller (CakePHP 3.10)
 */
class CaseStudiesController extends AppController
{
    /**
     * Initialize: load Paginator for index
     */
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Paginator');
    }

    /**
     * Admin: view single case study by slug
     *
     * @param string|null $slug Slug
     * @return \Cake\Http\Response|null
     */
    public function adminView($slug = null)
    {
        $this->viewBuilder()->setLayout('admin_layout');
        $this->set('title_for_layout', SITENAME . 'Case Detail Page');

        if (!$slug) {
            throw new NotFoundException();
        }

        $case = $this->CaseStudies->find()
            ->where([
                'CaseStudies.slug' => $slug,
                'CaseStudies.status' => 1,
            ])
            ->contain(['CaseImages'])
            ->first();

        if (empty($case)) {
            throw new NotFoundException();
        }

        $this->set(compact('case'));
        return null;
    }

    /**
     * Admin: list case studies
     *
     * @return \Cake\Http\Response|null
     */
    public function adminIndex()
    {
        $this->viewBuilder()->setLayout('admin_layout');

        $this->paginate = [
            'limit' => 10,
            'order' => ['CaseStudies.id' => 'DESC'],
            'contain' => ['CaseImages', 'Products'],
        ];

        $caseStudies = $this->paginate($this->CaseStudies);
        $this->set(compact('caseStudies'));
        return null;
    }

    /**
     * Admin: add case study
     *
     * @return \Cake\Http\Response|null
     */
    public function adminAdd()
    {
        $this->viewBuilder()->setLayout('admin_layout');
        $this->set('title_for_layout', SITENAME . 'Case Detail Page');

        $caseStudy = $this->CaseStudies->newEntity([]);

        if ($this->request->is('post')) {
            $data = $this->request->getData();
            // Support both flat (C3) and nested data[CaseStudy] (C2-style forms)
            if (isset($data['CaseStudy'])) {
                $data = $data['CaseStudy'];
            }
            $featuredImage = $data['featured_image'] ?? null;
            $datasheetFile = $data['datasheet_file'] ?? null;
            unset($data['featured_image'], $data['datasheet_file']);

            $caseStudy = $this->CaseStudies->patchEntity($caseStudy, $data);

            if ($this->CaseStudies->save($caseStudy)) {
                $caseId = $caseStudy->id;
                $this->_handleUploads($caseId, $featuredImage, $datasheetFile);

                $this->Flash->success('Case study saved');
                return $this->redirect(['controller' => 'CaseStudies', 'action' => 'adminIndex']);
            }

            $this->Flash->error('Save failed');
        }

        $this->loadModel('Products');
        $products = $this->Products->find('list', [
            'keyField' => 'id',
            'valueField' => 'title',
        ]);
        $this->set(compact('products', 'caseStudy'));
        return null;
    }

    /**
     * Admin: edit case study
     *
     * @param string|int|null $id Case study id
     * @return \Cake\Http\Response|null
     */
    public function adminEdit($id = null)
    {
        $this->viewBuilder()->setLayout('admin_layout');
        $this->set('title_for_layout', SITENAME . 'Case Detail Page');

        if (!$id) {
            throw new NotFoundException();
        }

        $caseStudy = $this->CaseStudies->get($id, [
            'contain' => ['CaseImages'],
        ]);

        if ($this->request->is(['post', 'put', 'patch'])) {
            $data = $this->request->getData();
            if (isset($data['CaseStudy'])) {
                $data = $data['CaseStudy'];
            }
            $featuredImage = $data['featured_image'] ?? null;
            $datasheetFile = $data['datasheet_file'] ?? null;
            unset($data['featured_image'], $data['datasheet_file']);

            $caseStudy = $this->CaseStudies->patchEntity($caseStudy, $data);

            if ($this->CaseStudies->save($caseStudy)) {
                $this->_editHandleUploads((int)$id, $featuredImage, $datasheetFile);

                $this->Flash->success('Case study updated successfully.');
                return $this->redirect(['controller' => 'CaseStudies', 'action' => 'adminIndex']);
            }

            $this->Flash->error('Save failed');
        } else {
            $this->request = $this->request->withParsedBody($caseStudy->toArray());
        }

        $this->loadModel('Products');
        $products = $this->Products->find('list', [
            'keyField' => 'id',
            'valueField' => 'title',
        ]);
        $this->set(compact('caseStudy', 'products'));
        return null;
    }

    /**
     * Admin: delete case study
     *
     * @param string|int|null $id Case study id
     * @return \Cake\Http\Response|null
     */
    public function adminDelete($id = null)
    {
        $this->viewBuilder()->setLayout('admin_layout');
        $this->set('title_for_layout', SITENAME . ' | Delete Case Study');

        if (!$id || !$this->CaseStudies->exists(['id' => $id])) {
            throw new NotFoundException(__('Invalid Case Study'));
        }

        $this->loadModel('CaseImages');
        $caseStudy = $this->CaseStudies->get($id);

        $this->CaseImages->deleteAll(['case_study_id' => $id]);

        $dirPath = WWW_ROOT . 'files' . DS . 'case_studies' . DS . $id . DS;
        if (is_dir($dirPath)) {
            $this->_deleteDirectory($dirPath);
        }

        if ($this->CaseStudies->delete($caseStudy)) {
            $this->Flash->success(__('Case study deleted successfully.'));
        } else {
            $this->Flash->error(__('Failed to delete case study.'));
        }

        return $this->redirect(['controller' => 'CaseStudies', 'action' => 'adminIndex']);
    }

    /**
     * Edit: handle file uploads (datasheet, featured image, images)
     *
     * @param int $caseId Case study id
     * @param array|null $featuredImage File data for featured image
     * @param array|null $datasheetFile File data for datasheet
     * @return void
     */
    protected function _editHandleUploads(int $caseId, $featuredImage = null, $datasheetFile = null): void
    {
        $this->loadModel('CaseImages');
        $data = $this->request->getData();
        if (isset($data['CaseStudy'])) {
            $data = array_merge($data, $data['CaseStudy']);
        }
        $uploadDir = WWW_ROOT . 'files' . DS . 'case_studies' . DS . $caseId . DS;

        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        // Datasheet (PDF)
        $ds = $datasheetFile ?? $data['datasheet_file'] ?? null;
        if (!empty($ds['tmp_name']) && ($ds['error'] ?? 0) === UPLOAD_ERR_OK) {
            $ext = strtolower(pathinfo($ds['name'], PATHINFO_EXTENSION));
            if ($ext === 'pdf') {
                $datasheetName = 'datasheet_' . time() . '.' . $ext;
                $dest = $uploadDir . $datasheetName;
                if (move_uploaded_file($ds['tmp_name'], $dest)) {
                    $entity = $this->CaseStudies->get($caseId);
                    $entity->datasheet = 'files/case_studies/' . $caseId . '/' . $datasheetName;
                    $this->CaseStudies->save($entity);
                }
            }
        }

        // Featured image
        $fi = $featuredImage ?? $data['featured_image'] ?? null;
        if (!empty($fi['tmp_name']) && ($fi['error'] ?? 0) === UPLOAD_ERR_OK) {
            $ext = strtolower(pathinfo($fi['name'], PATHINFO_EXTENSION));
            if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                $existing = $this->CaseStudies->get($caseId);
                if (!empty($existing->featured_image)) {
                    $oldPath = WWW_ROOT . $existing->featured_image;
                    if (file_exists($oldPath)) {
                        @unlink($oldPath);
                    }
                }

                $featuredName = 'featured_' . time() . '.' . $ext;
                $dest = $uploadDir . $featuredName;
                if (move_uploaded_file($fi['tmp_name'], $dest)) {
                    $entity = $this->CaseStudies->get($caseId);
                    $entity->featured_image = 'files/case_studies/' . $caseId . '/' . $featuredName;
                    $this->CaseStudies->save($entity);
                }
            }
        }

        // Multiple images
        $images = $data['images'] ?? [];
        if (!empty($images)) {
            $imgDir = $uploadDir . 'images' . DS;
            if (!file_exists($imgDir)) {
                mkdir($imgDir, 0755, true);
            }
            $allowedExts = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

            foreach ($images as $i => $file) {
                if (empty($file['tmp_name']) || ($file['error'] ?? 0) !== UPLOAD_ERR_OK) {
                    continue;
                }
                $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
                if (!in_array($ext, $allowedExts)) {
                    continue;
                }
                $safeName = 'caseimg_' . uniqid() . '.' . $ext;
                $finalPath = $imgDir . $safeName;

                if (move_uploaded_file($file['tmp_name'], $finalPath)) {
                    $imgEntity = $this->CaseImages->newEntity([
                        'case_study_id' => $caseId,
                        'filename' => 'files/case_studies/' . $caseId . '/images/' . $safeName,
                        'type' => $data['CaseImage']['type'][$i] ?? 'other',
                        'caption' => $data['CaseImage']['caption'][$i] ?? null,
                        'ordering' => 0,
                    ]);
                    $this->CaseImages->save($imgEntity);
                }
            }
        }

        // Update existing image details
        $existingImages = $data['ExistingImage'] ?? [];
        foreach ($existingImages as $imgId => $imgData) {
            if (!$this->CaseImages->exists(['id' => $imgId])) {
                continue;
            }
            $imgEntity = $this->CaseImages->get($imgId);
            $imgEntity->caption = $imgData['caption'] ?? null;
            $imgEntity->type = $imgData['type'] ?? 'other';
            $this->CaseImages->save($imgEntity);
        }
    }

    /**
     * Handle file uploads for add (datasheet, featured image, multiple images)
     *
     * @param int $caseId Case study id
     * @param array|null $featuredImage File data for featured image
     * @param array|null $datasheetFile File data for datasheet
     * @return void
     */
    protected function _handleUploads(int $caseId, $featuredImage = null, $datasheetFile = null): void
    {
        $this->loadModel('CaseImages');
        $data = $this->request->getData();
        if (isset($data['CaseStudy'])) {
            $data = array_merge($data, $data['CaseStudy']);
        }
        $uploadDir = WWW_ROOT . 'files' . DS . 'case_studies' . DS . $caseId . DS;

        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        // Datasheet (PDF)
        $ds = $datasheetFile ?? $data['datasheet_file'] ?? null;
        if (!empty($ds['tmp_name']) && ($ds['error'] ?? 0) === UPLOAD_ERR_OK) {
            $ext = strtolower(pathinfo($ds['name'], PATHINFO_EXTENSION));
            if ($ext === 'pdf') {
                $datasheetName = 'datasheet_' . time() . '.' . $ext;
                $dest = $uploadDir . $datasheetName;
                if (move_uploaded_file($ds['tmp_name'], $dest)) {
                    $entity = $this->CaseStudies->get($caseId);
                    $entity->datasheet = 'files/case_studies/' . $caseId . '/' . $datasheetName;
                    $this->CaseStudies->save($entity);
                }
            }
        }

        // Featured image
        $fi = $featuredImage ?? $data['featured_image'] ?? null;
        if (!empty($fi['tmp_name']) && ($fi['error'] ?? 0) === UPLOAD_ERR_OK) {
            $ext = strtolower(pathinfo($fi['name'], PATHINFO_EXTENSION));
            if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                $featuredName = 'featured_' . time() . '.' . $ext;
                $dest = $uploadDir . $featuredName;
                if (move_uploaded_file($fi['tmp_name'], $dest)) {
                    $entity = $this->CaseStudies->get($caseId);
                    $entity->featured_image = 'files/case_studies/' . $caseId . '/' . $featuredName;
                    $this->CaseStudies->save($entity);
                }
            }
        }

        // Multiple images (from form or $_FILES)
        $images = $data['images'] ?? [];
        if (empty($images) && !empty($_FILES['images']['name'][0])) {
            $total = count($_FILES['images']['name']);
            for ($i = 0; $i < $total; $i++) {
                if (($_FILES['images']['error'][$i] ?? 0) !== UPLOAD_ERR_OK) {
                    continue;
                }
                $images[] = [
                    'tmp_name' => $_FILES['images']['tmp_name'][$i],
                    'name' => $_FILES['images']['name'][$i],
                    'error' => $_FILES['images']['error'][$i],
                ];
            }
        }

        if (!empty($images)) {
            $imgDestDir = $uploadDir . 'images' . DS;
            if (!file_exists($imgDestDir)) {
                mkdir($imgDestDir, 0755, true);
            }
            $allowedExts = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

            foreach ($images as $i => $file) {
                $tmpName = is_array($file) ? ($file['tmp_name'] ?? null) : null;
                $name = is_array($file) ? ($file['name'] ?? '') : '';
                $err = is_array($file) ? ($file['error'] ?? 0) : 0;

                if (empty($tmpName) || $err !== UPLOAD_ERR_OK) {
                    continue;
                }
                $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
                if (!in_array($ext, $allowedExts)) {
                    continue;
                }
                $safeName = 'caseimg_' . time() . '_' . mt_rand(100, 999) . '.' . $ext;
                $fullPath = $imgDestDir . $safeName;

                if (move_uploaded_file($tmpName, $fullPath)) {
                    $imgEntity = $this->CaseImages->newEntity([
                        'case_study_id' => $caseId,
                        'filename' => 'files/case_studies/' . $caseId . '/images/' . $safeName,
                        'type' => $data['CaseImage']['type'][$i] ?? 'other',
                        'caption' => $data['CaseImage']['caption'][$i] ?? null,
                        'ordering' => 0,
                    ]);
                    $this->CaseImages->save($imgEntity);
                }
            }
        }
    }

    /**
     * Recursively delete a directory
     *
     * @param string $dir Path to directory
     * @return bool
     */
    protected function _deleteDirectory(string $dir): bool
    {
        if (!file_exists($dir)) {
            return true;
        }
        if (!is_dir($dir)) {
            return unlink($dir);
        }
        foreach (scandir($dir) as $item) {
            if ($item === '.' || $item === '..') {
                continue;
            }
            $path = $dir . DS . $item;
            if (is_dir($path)) {
                $this->_deleteDirectory($path);
            } else {
                unlink($path);
            }
        }
        return rmdir($dir);
    }

    /**
     * Admin: delete single case image
     *
     * @param string|int|null $id Image id
     * @return \Cake\Http\Response|null
     */
    public function adminDeleteImage($id = null)
    {
        $this->loadModel('CaseImages');

        if (!$id) {
            throw new NotFoundException(__('Invalid Image ID'));
        }

        $image = $this->CaseImages->get($id);
        if (!$image) {
            $this->Flash->error(__('Image not found.'));
            return $this->redirect($this->referer());
        }

        $filePath = WWW_ROOT . $image->filename;
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        if ($this->CaseImages->delete($image)) {
            $this->Flash->success(__('Image deleted successfully.'));
        } else {
            $this->Flash->error(__('Failed to delete image.'));
        }

        return $this->redirect($this->referer());
    }

    /**
     * Admin: approve case study
     *
     * @param string|int|null $id Case study id
     * @return \Cake\Http\Response|null
     */
    public function adminApprove($id = null)
    {
        if (!$id || !$this->CaseStudies->exists(['id' => $id])) {
            $this->Flash->error('Invalid Case Study ID');
            return $this->redirect(['controller' => 'CaseStudies', 'action' => 'adminIndex']);
        }

        $caseStudy = $this->CaseStudies->get($id);
        $caseStudy->status = 2;

        if ($this->CaseStudies->save($caseStudy)) {
            $this->Flash->success('Case Study approved successfully!');
        } else {
            $this->Flash->error('Failed to approve case study.');
        }

        return $this->redirect(['controller' => 'CaseStudies', 'action' => 'adminIndex']);
    }
}
