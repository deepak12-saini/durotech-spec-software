<?php 
declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;
use Cake\Http\Response;

/**
 * Broucher Products Controller (Brochure products - CakePHP 3.10)
 */
class BroucherProductsController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Paginator');
        $this->loadModel('BroucherProduct');
        $this->loadModel('BorucherCategory');
        $this->loadModel('Category');
        $this->loadModel('Project');
        $this->viewBuilder()->setOptions(['ext' => 'php']);
    }

    public function beforeFilter(EventInterface $event): ?Response
    {
        $result = parent::beforeFilter($event);
        if ($result instanceof Response) {
            return $result;
        }
        $this->callConstants();
        return null;
    }

    /**
     * CamelCase alias for routing: /admin/broucher_products -> admin_index
     */
    public function adminIndex(): ?Response
    {
        return $this->admin_index();
    }

    public function admin_index(): ?Response
    {
        $this->viewBuilder()->setLayout('admin_layout');
        $this->set('title_for_layout', SITENAME . ' Product List');
        $result = $this->checkAdminSession();
        if ($result instanceof Response) {
            return $result;
        }

        $name = trim((string)($this->request->getQuery('productname', $this->request->getData('productname') ?? '')));
        $query = $this->BroucherProduct->find()
            ->contain(['Category' => function ($q) {
                return $q->select(['category_name']);
            }, 'BorucherCategory'])
            ->orderDesc('BroucherProduct.created');
        if ($name !== '') {
            $query->where(['BroucherProduct.title LIKE' => '%' . $name . '%']);
        }
        $product = $this->paginate($query, ['limit' => 25]);
        $list = [];
        foreach ($product as $entity) {
            $list[] = [
                'BroucherProduct' => $entity->toArray(),
                'Category' => $entity->category ? ['category_name' => $entity->category->category_name ?? ''] : [],
                'BorucherCategory' => $entity->borucher_category ? $entity->borucher_category->toArray() : [],
            ];
        }
        $this->set('product', $list);
        $this->set('name', $name);
        return null;
    }

    public function adminAdd(): ?Response
    {
        return $this->admin_add();
    }

    public function admin_add(): ?Response
    {
        $this->viewBuilder()->setLayout('admin_layout');
        $this->set('title_for_layout', SITENAME . ' Add Broucher Product');
        $result = $this->checkAdminSession();
        if ($result instanceof Response) {
            return $result;
        }

        $categoryList = [];
        foreach ($this->Category->find('all') as $c) {
            $categoryList[] = ['Category' => ['id' => $c->id, 'category_name' => $c->category_name ?? '']];
        }
        $this->set('category', $categoryList);
        $borucherList = [];
        foreach ($this->BorucherCategory->find('all') as $b) {
            $borucherList[] = ['BorucherCategory' => ['id' => $b->id, 'title' => $b->title ?? '']];
        }
        $this->set('BorucherCategory', $borucherList);
        $this->set('product_code', $this->random_password(8));

        $data = $this->request->getData('data.BroucherProduct') ?? $this->request->getData('BroucherProduct');
        if (!empty($data) && is_array($data)) {
            $slug = str_replace(' ', '-', strtolower((string)($data['title'] ?? '')));
            $slug = str_replace('&', 'and', $slug);
            $imageFile = $data['image'] ?? null;
            unset($data['image']);
            $data['slug'] = $slug;
            $data['image'] = '250250-defult.png';
            $data['thumb_image'] = '250250-defult.png';
            if (isset($data['category_id']) && $data['category_id'] === '') {
                $data['category_id'] = null;
            }
            if (isset($data['boucher_cate_id']) && $data['boucher_cate_id'] === '') {
                $data['boucher_cate_id'] = null;
            }
            $entity = $this->BroucherProduct->newEntity($data, ['validate' => false, 'guard' => false]);
            if (is_array($imageFile) && !empty($imageFile['name'])) {
                $file = $imageFile;
                $ext = strtolower((string)pathinfo($file['name'], PATHINFO_EXTENSION));
                $arr_ext = ['jpg', 'jpeg', 'gif', 'png'];
                if (in_array($ext, $arr_ext, true)) {
                    $thumnail_image = time() . '_thumnail_' . $file['name'];
                    $path = WWW_ROOT . 'productimg' . DS . $thumnail_image;
                    $imgString = @file_get_contents($file['tmp_name']);
                    if ($imgString !== false) {
                        $imageRes = @imagecreatefromstring($imgString);
                        if ($imageRes !== false) {
                            $info = @getimagesize($file['tmp_name']);
                            if ($info) {
                                list($w, $h) = $info;
				$width = 285;
				$height = 380;
                                $ratio = max($width / $w, $height / $h);
                                $h = (int)ceil($height / $ratio);
                                $w = (int)ceil($width / $ratio);
				$tmp = imagecreatetruecolor($width, $height);
                                if ($tmp !== false) {
                                    imagecopyresampled($tmp, $imageRes, 0, 0, 0, 0, $width, $height, $w, $h);
                                    switch ($file['type'] ?? '') {
					case 'image/jpeg':
						imagejpeg($tmp, $path, 100);
						break;
					case 'image/png':
						imagepng($tmp, $path, 0);
						break;
					case 'image/gif':
						imagegif($tmp, $path);
						break;
					default:
						break;
				}
				imagedestroy($tmp);						
                                }
                                imagedestroy($imageRes);
                            }
                        }
                    }
                    move_uploaded_file($file['tmp_name'], WWW_ROOT . 'productimg' . DS . $file['name']);
                    $entity->image = $file['name'];
                    $entity->thumb_image = $thumnail_image;
                } else {
                    $this->Flash->error('Please upload a valid image (jpg, jpeg, gif, png).');
                    return null;
                }
            }
            if ($this->BroucherProduct->save($entity)) {
                $this->Flash->success('Product added successfully.');
                return $this->redirect(['controller' => 'BroucherProducts', 'action' => 'admin_index']);
            }
            $errors = $entity->getErrors();
            $errMsg = 'The product could not be saved. Please try again.';
            if (!empty($errors)) {
                $flat = [];
                array_walk_recursive($errors, function ($v) use (&$flat) {
                    $flat[] = $v;
                });
                $errMsg .= ' ' . implode(' ', array_slice($flat, 0, 3));
            }
            $this->Flash->error($errMsg);
        }
        return null;
    }

    public function adminEdit($id = null): ?Response
    {
        return $this->admin_edit($id);
    }

    public function admin_edit($id = null): ?Response
    {
        $this->viewBuilder()->setLayout('admin_layout');
        $this->set('title_for_layout', SITENAME . ' Edit Product');
        $result = $this->checkAdminSession();
        if ($result instanceof Response) {
            return $result;
        }

        $id = (int)$id;
        $entity = $this->BroucherProduct->get($id, ['contain' => ['Category', 'BorucherCategory']]);

        $categoryList = [];
        foreach ($this->Category->find('all') as $c) {
            $categoryList[] = ['Category' => ['id' => $c->id, 'category_name' => $c->category_name ?? '']];
        }
        $this->set('category', $categoryList);
        $borucherList = [];
        foreach ($this->BorucherCategory->find('all') as $b) {
            $borucherList[] = ['BorucherCategory' => ['id' => $b->id, 'title' => $b->title ?? '']];
        }
        $this->set('BorucherCategory', $borucherList);

        $data = $this->request->getData('data.BroucherProduct') ?? $this->request->getData('BroucherProduct');
        if (!empty($data) && is_array($data)) {
            $imageFile = $data['image'] ?? null;
            unset($data['image']);
            $slug = str_replace(' ', '-', strtolower((string)($data['title'] ?? '')));
            $slug = str_replace('&', 'and', $slug);
            $data['slug'] = $slug;
            if (isset($data['category_id']) && $data['category_id'] === '') {
                $data['category_id'] = null;
            }
            if (isset($data['boucher_cate_id']) && $data['boucher_cate_id'] === '') {
                $data['boucher_cate_id'] = null;
            }
            $entity = $this->BroucherProduct->patchEntity($entity, $data, ['validate' => false, 'guard' => false]);
            $image = $this->request->getData('data.BroucherProduct.image') ?? $this->request->getData('BroucherProduct.image') ?? $this->request->getData('image');
            if (is_array($image) && !empty($image['name'])) {
                $file = $image;
                $ext = strtolower((string)pathinfo($file['name'], PATHINFO_EXTENSION));
                $arr_ext = ['jpg', 'jpeg', 'gif', 'png'];
                if (in_array($ext, $arr_ext, true)) {
                    $thumnail_image = time() . '_thumnail_' . $file['name'];
                    $path = WWW_ROOT . 'productimg' . DS . $thumnail_image;
                    $imgString = @file_get_contents($file['tmp_name']);
                    if ($imgString !== false) {
                        $imageRes = @imagecreatefromstring($imgString);
                        if ($imageRes !== false) {
                            $info = @getimagesize($file['tmp_name']);
                            if ($info) {
                                list($w, $h) = $info;
			$width = 255;
			$height = 250;
                                $ratio = max($width / $w, $height / $h);
                                $h = (int)ceil($height / $ratio);
                                $w = (int)ceil($width / $ratio);
			$tmp = imagecreatetruecolor($width, $height);
                                if ($tmp !== false) {
                                    imagecopyresampled($tmp, $imageRes, 0, 0, 0, 0, $width, $height, $w, $h);
                                    switch ($file['type'] ?? '') {
				case 'image/jpeg':
					imagejpeg($tmp, $path, 100);
					break;
				case 'image/png':
					imagepng($tmp, $path, 0);
					break;
				case 'image/gif':
					imagegif($tmp, $path);
					break;
				default:
					break;
			}
			imagedestroy($tmp);
                                }
                                imagedestroy($imageRes);
                            }
                        }
                    }
                    move_uploaded_file($file['tmp_name'], WWW_ROOT . 'productimg' . DS . $file['name']);
                    $entity->image = $file['name'];
                    $entity->thumb_image = $thumnail_image;
                } else {
                    $this->Flash->error('Please upload a valid image (jpg, jpeg, gif, png).');
                }
            }
            if ($this->BroucherProduct->save($entity)) {
                $this->Flash->success('Product updated successfully.');
                return $this->redirect(['controller' => 'BroucherProducts', 'action' => 'admin_index']);
            }
            $this->Flash->error('The product could not be saved. Please try again.');
        }

        $product_arr = ['BroucherProduct' => $entity->toArray()];
        $this->set('product_arr', $product_arr);
        return null;
    }

    public function adminProjectdelete($product_id = null, $id = null): ?Response
    {
        return $this->admin_projectdelete($product_id, $id);
    }

    public function admin_projectdelete($product_id = null, $id = null): ?Response
    {
        $this->viewBuilder()->setLayout('admin_layout');
        $result = $this->checkAdminSession();
        if ($result instanceof Response) {
            return $result;
        }
        $project = $this->Project->get((int)$id);
        $this->Project->delete($project);
        $this->Flash->success('The product has been deleted.');
        return $this->redirect(['controller' => 'Products', 'action' => 'project', $product_id]);
    }

    public function adminDelete($id = null): ?Response
    {
        return $this->admin_delete($id);
    }

    public function admin_delete($id = null): ?Response
    {
        $this->viewBuilder()->setLayout('admin_layout');
        $result = $this->checkAdminSession();
        if ($result instanceof Response) {
            return $result;
        }
        $entity = $this->BroucherProduct->get((int)$id);
        $this->BroucherProduct->delete($entity);
        $this->Flash->success('The product has been deleted.');
        return $this->redirect(['action' => 'admin_index']);
    }

    public function download($file = null): ?Response
    {
		$this->autoRender = false;
        $filepath = WWW_ROOT . 'label' . DS . $file;
        if (file_exists($filepath)) {
            return $this->response->withFile($filepath, ['download' => true]);
        }
			return $this->redirect('/');
		}	

    public function openlistcate($slug = null): ?Response
    {
        $cat = $this->BorucherCategory->find()->where(['slug' => $slug])->first();
        if ($cat) {
            $bp = $this->BroucherProduct->find()->where(['boucher_cate_id' => $cat->id])->first();
            if ($bp) {
                return $this->redirect(['action' => 'openlist', $bp->slug]);
            }
        }
        return $this->redirect('/');
    }

    public function openlist($productslug = null): ?Response
    {
        $this->viewBuilder()->setLayout('customduro_layout');
        $entity = $this->BroucherProduct->find()
            ->contain(['BorucherCategory'])
            ->where(['BroucherProduct.slug' => $productslug])
            ->first();
        if ($entity) {
            $this->set('BroucherProduct', ['BroucherProduct' => $entity->toArray(), 'BorucherCategory' => $entity->borucher_category ? $entity->borucher_category->toArray() : []]);
            $boucher_cate_id = $entity->boucher_cate_id;
            $list = [];
            foreach ($this->BroucherProduct->find()->contain(['BorucherCategory'])->where(['BroucherProduct.boucher_cate_id' => $boucher_cate_id])->orderAsc('BroucherProduct.sort') as $e) {
                $list[] = ['BroucherProduct' => $e->toArray(), 'BorucherCategory' => $e->borucher_category ? $e->borucher_category->toArray() : []];
            }
            $this->set('BroucherProductListArr', $list);
            $this->set('BorucherCategory', $this->BorucherCategory->find()->where(['title !=' => 'other'])->toArray());
        } else {
            $this->Flash->error('Sorry, this product is not available.');
			return $this->redirect('/login');
		}	
        return null;
    }

    public function detail($productslug = null): ?Response
    {
        $this->viewBuilder()->setLayout('customduro_layout');
        $this->set('title_for_layout', SITENAME . ' Product Detail Page');
        $products = $this->BroucherProduct->find()
            ->contain(['BorucherCategory', 'Project'])
            ->where(['BroucherProduct.slug' => $productslug])
            ->first();
        if (!$products) {
            $this->Flash->error('Product not found.');
            return $this->redirect('/');
        }
        $products = ['BroucherProduct' => $products->toArray()];
		$this->set(compact('products'));
        $this->set('BorucherCategory', $this->BorucherCategory->find()->where(['title !=' => 'other'])->toArray());
        $conn = \Cake\Datasource\ConnectionManager::get('default');
        $random = $conn->execute('SELECT title, slug, image FROM broucher_products WHERE status = 1 ORDER BY RAND() LIMIT 4')->fetchAll('assoc');
        $this->set('random', $random);
        return null;
    }

    public function openlistnew($productslug = null): ?Response
    {
        $this->viewBuilder()->setLayout('customduro_layout');
        $list = $this->BorucherCategory->find()->contain(['BroucherProduct'])->toArray();
        $this->set('BroucherProductListArr', $list);
        return null;
    }

    public function rawmaterial($productslug = null): ?Response
    {
        $this->loadModel('Material');
        $this->viewBuilder()->setLayout('customduro_layout');
        $this->set('materials', $this->Material->find()->orderAsc('Material.material_type')->toArray());
        return null;
    }
}
