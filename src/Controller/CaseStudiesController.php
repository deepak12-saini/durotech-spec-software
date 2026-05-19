<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Exception\NotFoundException;
use Cake\Log\Log;
use Psr\Http\Message\UploadedFileInterface;

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
            unset($data['featured_image'], $data['datasheet_file'], $data['before_image'], $data['after_image']);

            $caseStudy = $this->CaseStudies->patchEntity($caseStudy, $data);

            if ($this->CaseStudies->save($caseStudy)) {
                $caseId = $caseStudy->id;
                $this->_handleUploads($caseId);

                $this->Flash->success('Case study saved');
                return $this->redirect(['controller' => 'CaseStudies', 'action' => 'adminIndex']);
            }

            $this->Flash->error('Save failed');
        }

        $this->loadModel('Products');
        $products = $this->Products->find('list', [
            'keyField' => 'id',
            'valueField' => 'title',
        ])
            ->where(['Products.status' => 1])
            ->orderAsc('Products.title');
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
            'contain' => ['CaseImages', 'Products'],
        ]);

        if ($this->request->is(['post', 'put', 'patch'])) {
            $data = $this->request->getData();
            if (isset($data['CaseStudy'])) {
                $data = $data['CaseStudy'];
            }
            unset($data['featured_image'], $data['datasheet_file'], $data['before_image'], $data['after_image']);

            $caseStudy = $this->CaseStudies->patchEntity($caseStudy, $data);

            if ($this->CaseStudies->save($caseStudy)) {
                $this->_editHandleUploads((int)$id);

                $this->Flash->success('Case study updated successfully.');
                return $this->redirect(['controller' => 'CaseStudies', 'action' => 'adminEdit', $id]);
            }

            $this->Flash->error('Save failed');
        } else {
            $preselectedProductIds = [];
            if (!empty($caseStudy->products)) {
                foreach ($caseStudy->products as $prod) {
                    if (isset($prod->id)) {
                        $preselectedProductIds[] = (int)$prod->id;
                    }
                }
            }
            $seed = $caseStudy->toArray();
            $seed['products'] = ['_ids' => $preselectedProductIds];
            $this->request = $this->request->withParsedBody($seed);
        }

        $this->loadModel('Products');
        $products = $this->Products->find('list', [
            'keyField' => 'id',
            'valueField' => 'title',
        ])
            ->where(['Products.status' => 1])
            ->orderAsc('Products.title');
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
     * Edit: handle file uploads (datasheet, featured image, before/after)
     *
     * @param int $caseId Case study id
     * @return void
     */
    protected function _editHandleUploads(int $caseId): void
    {
        $uploadDir = $this->_ensureCaseStudyUploadDir($caseId);

        $this->_saveDatasheet($caseId, $uploadDir);
        $this->_saveFeaturedImage($caseId, $uploadDir, true);
        $this->_saveTypedCaseImage($caseId, $this->_resolveUploadedFile('before_image'), 'before');
        $this->_saveTypedCaseImage($caseId, $this->_resolveUploadedFile('after_image'), 'after');

        $data = $this->request->getData();
        if (isset($data['CaseStudy'])) {
            $data = array_merge($data, $data['CaseStudy']);
        }
        $existingImages = $data['ExistingImage'] ?? [];
        if (!empty($existingImages)) {
            $this->loadModel('CaseImages');
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
    }

    /**
     * Handle file uploads for add (datasheet, featured image, before/after)
     *
     * @param int $caseId Case study id
     * @return void
     */
    protected function _handleUploads(int $caseId): void
    {
        $uploadDir = $this->_ensureCaseStudyUploadDir($caseId);

        $this->_saveDatasheet($caseId, $uploadDir);
        $this->_saveFeaturedImage($caseId, $uploadDir, false);
        $this->_saveTypedCaseImage($caseId, $this->_resolveUploadedFile('before_image'), 'before');
        $this->_saveTypedCaseImage($caseId, $this->_resolveUploadedFile('after_image'), 'after');
    }

    /**
     * Get file array from $_FILES for nested name like data[CaseStudy][datasheet_file].
     *
     * @param string $base Base key (e.g. data)
     * @param string $key1 First nested key (e.g. CaseStudy)
     * @param string $key2 Second nested key (e.g. datasheet_file)
     * @return array|null
     */
    protected function _getUploadedFile(string $base, string $key1, string $key2): ?array
    {
        if (empty($_FILES[$base]['tmp_name'][$key1][$key2])) {
            return null;
        }
        $tmp = $_FILES[$base]['tmp_name'][$key1][$key2];
        if (!is_string($tmp) || !is_uploaded_file($tmp)) {
            return null;
        }

        return [
            'tmp_name' => $tmp,
            'name' => $_FILES[$base]['name'][$key1][$key2] ?? '',
            'error' => (int)($_FILES[$base]['error'][$key1][$key2] ?? UPLOAD_ERR_NO_FILE),
            'type' => $_FILES[$base]['type'][$key1][$key2] ?? '',
            'size' => (int)($_FILES[$base]['size'][$key1][$key2] ?? 0),
        ];
    }

    /**
     * Get file array from $_FILES for a flat field name (e.g. before_image).
     *
     * @param string $field Field name
     * @return array|null
     */
    protected function _getFlatUploadedFile(string $field): ?array
    {
        if (empty($_FILES[$field]['tmp_name'])) {
            return null;
        }
        $tmp = $_FILES[$field]['tmp_name'];
        if (!is_string($tmp) || !is_uploaded_file($tmp)) {
            return null;
        }

        return [
            'tmp_name' => $tmp,
            'name' => $_FILES[$field]['name'] ?? '',
            'error' => (int)($_FILES[$field]['error'] ?? UPLOAD_ERR_NO_FILE),
            'type' => $_FILES[$field]['type'] ?? '',
            'size' => (int)($_FILES[$field]['size'] ?? 0),
        ];
    }

    /**
     * Resolve an uploaded file from nested or flat $_FILES / getData.
     *
     * @param string $field Field name (featured_image, datasheet_file, before_image, after_image)
     * @return array|null
     */
    protected function _resolveUploadedFile(string $field)
    {
        $psr7 = $this->request->getUploadedFile($field);
        if ($psr7 instanceof UploadedFileInterface && $psr7->getError() === UPLOAD_ERR_OK) {
            return $psr7;
        }

        $nested = $this->request->getUploadedFile('CaseStudy.' . $field);
        if ($nested instanceof UploadedFileInterface && $nested->getError() === UPLOAD_ERR_OK) {
            return $nested;
        }

        $file = $this->_getUploadedFile('data', 'CaseStudy', $field)
            ?? $this->_getFlatUploadedFile($field);

        if ($file !== null) {
            return $file;
        }

        $data = $this->request->getData();
        $candidates = [
            $data[$field] ?? null,
            $data['CaseStudy'][$field] ?? null,
        ];
        foreach ($candidates as $candidate) {
            if ($candidate instanceof UploadedFileInterface && $candidate->getError() === UPLOAD_ERR_OK) {
                return $candidate;
            }
            if (is_array($candidate) && !empty($candidate['tmp_name']) && ($candidate['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_OK) {
                return $candidate;
            }
        }

        return null;
    }

    /**
     * Move an uploaded file (PSR-7 or PHP array) to destination path.
     *
     * @param array|UploadedFileInterface $file Upload payload
     * @param string $dest Absolute destination path
     * @return bool
     */
    protected function _moveUploadTo($file, string $dest): bool
    {
        if ($file instanceof UploadedFileInterface) {
            if ($file->getError() !== UPLOAD_ERR_OK) {
                return false;
            }
            try {
                $file->moveTo($dest);

                return true;
            } catch (\Throwable $e) {
                Log::error('Case study upload moveTo failed: ' . $e->getMessage());

                return false;
            }
        }

        if (!is_array($file) || empty($file['tmp_name']) || ($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
            return false;
        }

        $tmp = $file['tmp_name'];
        if (is_uploaded_file($tmp)) {
            return move_uploaded_file($tmp, $dest);
        }

        if (is_string($tmp) && file_exists($tmp)) {
            return copy($tmp, $dest);
        }

        return false;
    }

    /**
     * Get original filename from upload payload.
     *
     * @param array|UploadedFileInterface $file Upload payload
     * @return string
     */
    protected function _uploadClientFilename($file): string
    {
        if ($file instanceof UploadedFileInterface) {
            return $file->getClientFilename() ?? '';
        }

        return $file['name'] ?? '';
    }

    /**
     * Ensure upload directory exists for a case study.
     *
     * @param int $caseId Case study id
     * @return string Absolute upload directory path
     */
    protected function _ensureCaseStudyUploadDir(int $caseId): string
    {
        $uploadDir = WWW_ROOT . 'files' . DS . 'case_studies' . DS . $caseId . DS;
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        return $uploadDir;
    }

    /**
     * Save datasheet PDF for a case study.
     *
     * @param int $caseId Case study id
     * @param string $uploadDir Upload directory
     * @return void
     */
    protected function _saveDatasheet(int $caseId, string $uploadDir): void
    {
        $ds = $this->_resolveUploadedFile('datasheet_file');
        if ($ds === null) {
            return;
        }

        $ext = strtolower(pathinfo($this->_uploadClientFilename($ds), PATHINFO_EXTENSION));
        if ($ext !== 'pdf') {
            return;
        }

        $datasheetName = 'datasheet_' . time() . '.' . $ext;
        $dest = $uploadDir . $datasheetName;
        if ($this->_moveUploadTo($ds, $dest)) {
            $entity = $this->CaseStudies->get($caseId);
            $entity->datasheet = 'files/case_studies/' . $caseId . '/' . $datasheetName;
            $this->CaseStudies->save($entity);
        }
    }

    /**
     * Save featured image for a case study.
     *
     * @param int $caseId Case study id
     * @param string $uploadDir Upload directory
     * @param bool $replaceExisting Whether to delete the previous featured image file
     * @return void
     */
    protected function _saveFeaturedImage(int $caseId, string $uploadDir, bool $replaceExisting): void
    {
        $fi = $this->_resolveUploadedFile('featured_image');
        if ($fi === null) {
            return;
        }

        $ext = strtolower(pathinfo($this->_uploadClientFilename($fi), PATHINFO_EXTENSION));
        if (!in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'], true)) {
            return;
        }

        if ($replaceExisting) {
            $existing = $this->CaseStudies->get($caseId);
            if (!empty($existing->featured_image)) {
                $oldPath = WWW_ROOT . $existing->featured_image;
                if (file_exists($oldPath)) {
                    @unlink($oldPath);
                }
            }
        }

        $featuredName = 'featured_' . time() . '.' . $ext;
        $dest = $uploadDir . $featuredName;
        if ($this->_moveUploadTo($fi, $dest)) {
            $entity = $this->CaseStudies->get($caseId);
            $entity->featured_image = 'files/case_studies/' . $caseId . '/' . $featuredName;
            $this->CaseStudies->save($entity);
        }
    }

    /**
     * Save or replace a typed case image (before / after).
     *
     * @param int $caseId Case study id
     * @param array|null $file Uploaded file array
     * @param string $type Image type (before|after)
     * @return void
     */
    protected function _saveTypedCaseImage(int $caseId, $file, string $type): void
    {
        if (!in_array($type, ['before', 'after'], true)) {
            return;
        }
        if ($file === null) {
            return;
        }

        $ext = strtolower(pathinfo($this->_uploadClientFilename($file), PATHINFO_EXTENSION));
        if (!in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'], true)) {
            return;
        }

        $this->loadModel('CaseImages');
        $existing = $this->CaseImages->find()
            ->where(['case_study_id' => $caseId, 'type' => $type])
            ->all();

        foreach ($existing as $row) {
            $filePath = WWW_ROOT . $row->filename;
            if (file_exists($filePath)) {
                @unlink($filePath);
            }
            $this->CaseImages->delete($row);
        }

        $uploadDir = $this->_ensureCaseStudyUploadDir($caseId);
        $imgDir = $uploadDir . 'images' . DS;
        if (!file_exists($imgDir)) {
            mkdir($imgDir, 0755, true);
        }

        $safeName = $type . '_' . time() . '_' . mt_rand(100, 999) . '.' . $ext;
        $finalPath = $imgDir . $safeName;

        if ($this->_moveUploadTo($file, $finalPath)) {
            $imgEntity = $this->CaseImages->newEntity([
                'case_study_id' => $caseId,
                'filename' => 'files/case_studies/' . $caseId . '/images/' . $safeName,
                'type' => $type,
                'caption' => null,
                'ordering' => $type === 'before' ? 0 : 1,
            ]);
            if (!$this->CaseImages->save($imgEntity)) {
                Log::error('Failed to save case image: ' . json_encode($imgEntity->getErrors()));
                @unlink($finalPath);
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
     * Admin: remove featured (cover) image from a case study.
     *
     * @param string|int|null $id Case study id
     * @return \Cake\Http\Response|null
     */
    public function adminDeleteFeatured($id = null)
    {
        return $this->_adminClearCaseStudyMediaField($id, 'featured_image', __('Cover image removed.'));
    }

    /**
     * Admin: remove datasheet from a case study.
     *
     * @param string|int|null $id Case study id
     * @return \Cake\Http\Response|null
     */
    public function adminDeleteDatasheet($id = null)
    {
        return $this->_adminClearCaseStudyMediaField($id, 'datasheet', __('Datasheet removed.'));
    }

    /**
     * Clear a file column on a case study and delete the file from disk.
     *
     * @param string|int|null $id Case study id
     * @param string $field featured_image|datasheet
     * @param string $successMessage Flash message on success
     * @return \Cake\Http\Response|null
     */
    protected function _adminClearCaseStudyMediaField($id, string $field, string $successMessage)
    {
        if (!$id || !in_array($field, ['featured_image', 'datasheet'], true)) {
            throw new NotFoundException(__('Invalid request'));
        }

        $entity = $this->CaseStudies->get((int)$id);
        $path = (string)($entity->get($field) ?? '');
        if ($path !== '') {
            $filePath = WWW_ROOT . str_replace('/', DS, ltrim($path, '/'));
            if (file_exists($filePath)) {
                @unlink($filePath);
            }
        }

        $entity->set($field, null);
        if ($this->CaseStudies->save($entity)) {
            $this->Flash->success($successMessage);
        } else {
            $this->Flash->error(__('Could not remove file.'));
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
