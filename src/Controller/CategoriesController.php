<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;
use Cake\Http\Response;

/**
 * Categories Controller (Admin)
 */
class CategoriesController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Paginator');
        $this->loadModel('Categories');
        $this->viewBuilder()->setOptions(['ext' => 'php']);
    }

    public function beforeFilter(EventInterface $event): ?Response
    {
        parent::beforeFilter($event);
        $this->callConstants();
        return null;
    }

    /**
     * Admin: Category list
     */
    public function adminIndex(): void
    {
        $this->viewBuilder()->setLayout('admin_layout');
        $this->set('title_for_layout', SITENAME . ' Categories');
        $this->checkAdminSession();

        $query = $this->Categories->find();

        // Simple search / filter: by name or slug text and active status
        $search = trim((string)$this->request->getQuery('q', ''));
        $status = $this->request->getQuery('status', '');

        if ($search !== '') {
            $like = '%' . $search . '%';
            $query = $query->where([
                'OR' => [
                    'Categories.category_name LIKE' => $like,
                    'Categories.slug LIKE' => $like,
                    'Categories.description LIKE' => $like,
                ],
            ]);
        }

        if ($status !== '' && ($status === '1' || $status === '0')) {
            $query = $query->where(['Categories.status' => (int)$status]);
        }

        $this->paginate = [
            'limit' => 25,
            'order' => ['Categories.sort' => 'ASC', 'Categories.id' => 'DESC'],
        ];
        $query = $query->orderAsc('Categories.sort')->orderDesc('Categories.id');
        $results = $this->paginate($query);
        $categories = [];
        foreach ($results as $row) {
            $categories[] = ['Category' => $row->toArray()];
        }
        $this->set(compact('categories', 'search', 'status'));
    }

    /**
     * Admin: Add category
     */
    public function adminAdd(): ?Response
    {
        $this->viewBuilder()->setLayout('admin_layout');
        $this->set('title_for_layout', SITENAME . ' Add New Category');
        $this->checkAdminSession();

        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $categoryData = $data['Category'] ?? $data['data']['Category'] ?? [];
            $catSlug = str_replace(' ', '-', strtolower($categoryData['category_name'] ?? ''));
            $catSlug = str_replace('&', 'and', $catSlug);
            $categoryData['slug'] = $catSlug;
            // Default sequence (sort) to next value if not provided
            if (!isset($categoryData['sort']) || $categoryData['sort'] === '') {
                $q = $this->Categories->find();
                $maxRow = $q->select(['sort' => $q->func()->max('sort')])->first();
                $categoryData['sort'] = $maxRow && $maxRow->get('sort') !== null ? (int)$maxRow->get('sort') + 1 : 0;
            } else {
                $categoryData['sort'] = (int)$categoryData['sort'];
            }

            if (!empty($data['image']['name'])) {
                $file = $data['image'];
                $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
                $arrExt = ['jpg', 'jpeg', 'gif', 'png'];
                if (in_array($ext, $arrExt)) {
                    $uploadPath = WWW_ROOT . 'category' . DS;
                    if (!is_dir($uploadPath)) {
                        mkdir($uploadPath, 0755, true);
                    }
                    $dest = $uploadPath . $file['name'];
                    if (move_uploaded_file($file['tmp_name'], $dest)) {
                        $categoryData['image'] = $file['name'];
                    }
                } else {
                    $this->Flash->error('Please upload a valid image extension (jpg, jpeg, gif, png).');
                    return $this->redirect(rtrim(SITEURL, '/') . '/admin/categories/add');
                }
            } else {
                $categoryData['image'] = '250250-defult.png';
            }

            if (!empty($data['category_page_image']['name'])) {
                $file = $data['category_page_image'];
                $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
                $arrExt = ['jpg', 'jpeg', 'gif', 'png'];
                if (in_array($ext, $arrExt)) {
                    $uploadPath = WWW_ROOT . 'category' . DS;
                    if (!is_dir($uploadPath)) {
                        mkdir($uploadPath, 0755, true);
                    }
                    $dest = $uploadPath . $file['name'];
                    if (move_uploaded_file($file['tmp_name'], $dest)) {
                        $categoryData['category_page_image'] = $file['name'];
                    }
                } else {
                    $this->Flash->error('Please upload a valid category page image extension (jpg, jpeg, gif, png).');
                    return $this->redirect(rtrim(SITEURL, '/') . '/admin/categories/add');
                }
            }

            $entity = $this->Categories->newEntity($categoryData);
            if ($this->Categories->save($entity)) {
                $this->Flash->success('The Category has been saved');
                return $this->redirect(rtrim(SITEURL, '/') . '/admin/categories');
            }
            $this->Flash->error('The Category could not be saved. Please, try again.');
        }
        return null;
    }

    /**
     * Admin: Edit category
     */
    public function adminEdit($id = null): ?Response
    {
        $this->viewBuilder()->setLayout('admin_layout');
        $this->set('title_for_layout', SITENAME . ' Edit Category');
        $this->checkAdminSession();

        $category = $this->Categories->get($id);
        $id = (int)$id;

        if ($this->request->is(['post', 'put', 'patch'])) {
            $data = $this->request->getData();
            if (empty($data) || !is_array($data)) {
                $this->Flash->error('No data received. Please submit the form again.');
                $Category = ['Category' => $category->toArray()];
                $this->set(compact('Category', 'category'));
                return null;
            }
            // Normalize: form sends Category[...] (CakePHP Form helper) or data[Category][...]
            $categoryData = $data['Category'] ?? $data['data']['Category'] ?? [];
            if (!is_array($categoryData)) {
                $categoryData = [];
            }
            if (empty($categoryData) && !empty($data)) {
                $categoryData = array_intersect_key($data, array_flip([
                    'category_name', 'description', 'slug', 'image', 'category_page_image', 'meta_title', 'meta_keyword',
                    'meta_description', 'status', 'is_brand', 'id', 'sort'
                ]));
            }
            if (!empty($data) && is_array($data)) {
                $categoryData = array_merge($categoryData, array_intersect_key($data, array_flip([
                    'category_name', 'description', 'meta_title', 'meta_keyword', 'meta_description', 'status', 'is_brand', 'sort', 'category_page_image'
                ])));
            }

            $categoryName = (string)($categoryData['category_name'] ?? '');
            $catSlug = str_replace(' ', '-', strtolower($categoryName));
            $catSlug = str_replace('&', 'and', $catSlug);
            $categoryData['slug'] = $catSlug;

            if (!empty($data['image']['name'])) {
                $file = $data['image'];
                $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
                $arrExt = ['jpg', 'jpeg', 'gif', 'png'];
                if (in_array($ext, $arrExt)) {
                    $uploadPath = WWW_ROOT . 'category' . DS;
                    if (!is_dir($uploadPath)) {
                        mkdir($uploadPath, 0755, true);
                    }
                    $dest = $uploadPath . $file['name'];
                    if (move_uploaded_file($file['tmp_name'], $dest)) {
                        $categoryData['image'] = $file['name'];
                    }
                } else {
                    $this->Flash->error('Please upload a valid image extension.');
                    return $this->redirect(rtrim(SITEURL, '/') . '/admin/categories/edit/' . $id);
                }
            } else {
                $categoryData['image'] = $category->get('image') ?? '250250-defult.png';
            }

            if (!empty($data['category_page_image']['name'])) {
                $file = $data['category_page_image'];
                $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
                $arrExt = ['jpg', 'jpeg', 'gif', 'png'];
                if (in_array($ext, $arrExt)) {
                    $uploadPath = WWW_ROOT . 'category' . DS;
                    if (!is_dir($uploadPath)) {
                        mkdir($uploadPath, 0755, true);
                    }
                    $dest = $uploadPath . $file['name'];
                    if (move_uploaded_file($file['tmp_name'], $dest)) {
                        $categoryData['category_page_image'] = $file['name'];
                    }
                } else {
                    $this->Flash->error('Please upload a valid category page image extension.');
                    return $this->redirect(rtrim(SITEURL, '/') . '/admin/categories/edit/' . $id);
                }
            } else {
                $categoryData['category_page_image'] = $category->get('category_page_image') ?? '';
            }

            if (!array_key_exists('status', $categoryData)) {
                $categoryData['status'] = $category->get('status');
            }
            if (!array_key_exists('is_brand', $categoryData)) {
                $categoryData['is_brand'] = $category->get('is_brand');
            }

            // Build SET clause for UPDATE - use table's connection for explicit UPDATE on 'categories'
            $allowed = ['category_name', 'description', 'slug', 'image', 'category_page_image', 'meta_title', 'meta_keyword', 'meta_description', 'status', 'is_brand', 'sort'];
            $toUpdate = [];
            foreach ($allowed as $field) {
                if (array_key_exists($field, $categoryData)) {
                    $toUpdate[$field] = $field === 'sort' ? (int)$categoryData[$field] : $categoryData[$field];
                }
            }

            if (empty($toUpdate)) {
                $this->Flash->error('No category fields to update. Please check the form.');
                $Category = ['Category' => $category->toArray()];
                $this->set(compact('Category', 'category'));
                return null;
            }

            $table = $this->Categories->getTable();
            $conn = $this->Categories->getConnection();
            $stmt = $conn->update($table, $toUpdate, ['id' => $id]);
            $stmt->closeCursor();

            $this->Flash->success('The Category has been updated');
            return $this->redirect(rtrim(SITEURL, '/') . '/admin/categories');
        } else {
            $Category = ['Category' => $category->toArray()];
            $this->set(compact('Category', 'category'));
        }
        return null;
    }

    /**
     * Serve category image from webroot/category/ (for listing and edit form).
     */
    public function serveImage(): ?Response
    {
        $this->request->allowMethod(['GET']);
        $name = $this->request->getParam('pass.0');
        if ($name === null || $name === '') {
            return $this->response->withStatus(404);
        }
        $safeName = basename($name);
        if (strpos($safeName, '..') !== false) {
            return $this->response->withStatus(400);
        }
        $filePath = WWW_ROOT . 'category' . DS . $safeName;
        if (!is_file($filePath)) {
            return $this->response->withStatus(404);
        }
        $ext = strtolower(pathinfo($safeName, PATHINFO_EXTENSION));
        $mime = ['jpg' => 'image/jpeg', 'jpeg' => 'image/jpeg', 'png' => 'image/png', 'gif' => 'image/gif'][$ext] ?? 'application/octet-stream';
        $this->response = $this->response->withHeader('Content-Type', $mime);
        $this->response = $this->response->withFile($filePath, ['download' => false]);
        $this->viewBuilder()->setLayout(false);
        return $this->response;
    }

    /**
     * Admin: Delete category
     */
    public function adminDelete($id = null): Response
    {
        $this->viewBuilder()->setLayout('admin_layout');
        $this->set('title_for_layout', SITENAME . ' Delete');
        $this->checkAdminSession();

        $category = $this->Categories->get($id);
        if ($this->Categories->delete($category)) {
            $this->Flash->success('The Category has been deleted.');
        } else {
            $this->Flash->error('The Category could not be deleted. Please, try again.');
        }
        return $this->redirect(rtrim(SITEURL, '/') . '/admin/categories');
    }
}
