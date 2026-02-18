<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Exception\NotFoundException;

/**
 * Testimonials Controller (CakePHP 3.10)
 */
class TestimonialsController extends AppController
{
    /**
     * Admin: list all testimonials
     */
    public function admin_index()
    {
        $this->viewBuilder()->setLayout('admin_layout');
        $this->set('title_for_layout', SITENAME . 'Testimonial Page');
        $this->checkAdminSession();

        $testimonials = $this->Testimonials->find()
            ->contain(['Employees'])
            ->orderAsc('Testimonials.display_order')
            ->orderDesc('Testimonials.id');
        $this->set(compact('testimonials'));
    }

    /**
     * Employee: list testimonials created by logged-in employee
     */
    public function employee_index()
    {
        $this->viewBuilder()->setLayout('employee_layout');
        $this->set('title_for_layout', SITENAME . ' - Testimonials');
        $this->checkEmployeeSession();

        $session = $this->request->getSession();
        $employee_id = $session->read('Employee.id');
        if (!$employee_id) {
            $this->Flash->error('Please log in.');
            return $this->redirect(['controller' => 'Employees', 'action' => 'login']);
        }

        $testimonials = $this->Testimonials->find()
            ->where(['Testimonials.created_by' => $employee_id]);
        $this->set(compact('testimonials'));
    }

    /**
     * Employee: add testimonial
     */
    public function employee_add()
    {
        $this->viewBuilder()->setLayout('employee_layout');
        $this->set('title_for_layout', SITENAME . ' - Add Testimonial');
        $this->checkEmployeeSession();

        $session = $this->request->getSession();
        $employee_id = $session->read('Employee.id');
        if (!$employee_id) {
            $this->Flash->error('Please log in.');
            return $this->redirect(['controller' => 'Employees', 'action' => 'login']);
        }

        $testimonial = $this->Testimonials->newEntity([]);

        if ($this->request->is('post')) {
            $data = $this->request->getData();
            if (isset($data['Testimonial'])) {
                $data = $data['Testimonial'];
            }
            $data['created_by'] = $employee_id;
            $data['status'] = 0;

            if (!empty($data['photo']['name'])) {
                $file = $data['photo'];
                $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
                $allowedExt = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                if (in_array($ext, $allowedExt)) {
                    $filename = uniqid('testi_') . '.' . $ext;
                    $uploadPath = WWW_ROOT . 'img' . DS . 'testimonials' . DS;
                    if (!file_exists($uploadPath)) {
                        mkdir($uploadPath, 0777, true);
                    }
                    if (move_uploaded_file($file['tmp_name'], $uploadPath . $filename)) {
                        $data['photo'] = 'testimonials/' . $filename;
                    } else {
                        $this->Flash->error('Error uploading the image.');
                        unset($data['photo']);
                    }
                } else {
                    $this->Flash->error('Invalid image format. Allowed: JPG, PNG, GIF, WEBP.');
                    unset($data['photo']);
                }
            } else {
                unset($data['photo']);
            }

            $testimonial = $this->Testimonials->patchEntity($testimonial, $data);
            if ($this->Testimonials->save($testimonial)) {
                $this->Flash->success('Your testimonial has been submitted for admin approval.');
                return $this->redirect(['action' => 'employee_index']);
            }
            $this->Flash->error('Unable to save testimonial. Please try again.');
        }

        $this->set(compact('testimonial'));
    }

    /**
     * Admin: add testimonial
     */
    public function admin_add()
    {
        $this->viewBuilder()->setLayout('admin_layout');
        $this->set('title_for_layout', SITENAME . ' - Add Testimonial');
        $this->checkAdminSession();

        $testimonial = $this->Testimonials->newEntity([]);

        if ($this->request->is('post')) {
            $data = $this->request->getData();
            if (isset($data['Testimonial'])) {
                $data = $data['Testimonial'];
            }

            if (!empty($data['photo']['name'])) {
                $file = $data['photo'];
                $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
                $allowedExt = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                if (in_array($ext, $allowedExt)) {
                    $filename = uniqid('testi_') . '.' . $ext;
                    $uploadPath = WWW_ROOT . 'img' . DS . 'testimonials' . DS;
                    if (!file_exists($uploadPath)) {
                        mkdir($uploadPath, 0777, true);
                    }
                    if (move_uploaded_file($file['tmp_name'], $uploadPath . $filename)) {
                        $data['photo'] = 'testimonials/' . $filename;
                    } else {
                        $this->Flash->error('Error uploading the image.');
                        unset($data['photo']);
                    }
                } else {
                    $this->Flash->error('Invalid image format. Allowed: JPG, PNG, GIF, WEBP.');
                    unset($data['photo']);
                }
            } else {
                unset($data['photo']);
            }

            $testimonial = $this->Testimonials->patchEntity($testimonial, $data);
            if ($this->Testimonials->save($testimonial)) {
                $this->Flash->success('Testimonial added successfully!');
                return $this->redirect(['action' => 'admin_index']);
            }
            $this->Flash->error('Unable to save testimonial.');
        }

        $this->set(compact('testimonial'));
    }

    /**
     * Admin: edit testimonial
     */
    public function admin_edit($id = null)
    {
        $this->viewBuilder()->setLayout('admin_layout');
        $this->set('title_for_layout', SITENAME . ' - Edit Testimonial');
        $this->checkAdminSession();

        if (!$id || !$this->Testimonials->exists(['id' => $id])) {
            throw new NotFoundException('Invalid testimonial');
        }

        $existing = $this->Testimonials->get($id);
        $this->set('existing', $existing);

        if ($this->request->is(['post', 'put', 'patch'])) {
            $data = $this->request->getData();
            if (isset($data['Testimonial'])) {
                $data = $data['Testimonial'];
            }

            if (!empty($data['photo']['name'])) {
                $file = $data['photo'];
                $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
                $allowedExt = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                if (in_array($ext, $allowedExt)) {
                    $filename = uniqid('testi_') . '.' . $ext;
                    $uploadPath = WWW_ROOT . 'img' . DS . 'testimonials' . DS;
                    if (!file_exists($uploadPath)) {
                        mkdir($uploadPath, 0777, true);
                    }
                    if (move_uploaded_file($file['tmp_name'], $uploadPath . $filename)) {
                        if (!empty($existing->photo) && file_exists(WWW_ROOT . 'img' . DS . $existing->photo)) {
                            unlink(WWW_ROOT . 'img' . DS . $existing->photo);
                        }
                        $data['photo'] = 'testimonials/' . $filename;
                    }
                } else {
                    $this->Flash->error('Invalid image type. Allowed: JPG, PNG, GIF, WEBP.');
                    unset($data['photo']);
                }
            } else {
                unset($data['photo']);
            }

            $existing = $this->Testimonials->patchEntity($existing, $data);
            if ($this->Testimonials->save($existing)) {
                $this->Flash->success('Testimonial updated successfully!');
                return $this->redirect(['action' => 'admin_index']);
            }
            $this->Flash->error('Failed to update testimonial.');
        } else {
            $this->request = $this->request->withParsedBody($existing->toArray());
        }

        $this->set(compact('existing'));
    }

    /**
     * Employee: edit testimonial
     */
    public function employee_edit($id = null)
    {
        $this->viewBuilder()->setLayout('employee_layout');
        $this->set('title_for_layout', SITENAME . ' - Edit Testimonial');
        $this->checkEmployeeSession();

        if (!$id || !$this->Testimonials->exists(['id' => $id])) {
            throw new NotFoundException(__('Invalid testimonial'));
        }

        $existing = $this->Testimonials->get($id);
        $this->set('existing', $existing);

        if ($this->request->is(['post', 'put', 'patch'])) {
            $data = $this->request->getData();
            if (isset($data['Testimonial'])) {
                $data = $data['Testimonial'];
            }

            if (!empty($data['photo']['name'])) {
                $file = $data['photo'];
                $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
                $allowedExt = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                if (in_array($ext, $allowedExt)) {
                    $filename = uniqid('testi_') . '.' . $ext;
                    $uploadPath = WWW_ROOT . 'img' . DS . 'testimonials' . DS;
                    if (!file_exists($uploadPath)) {
                        mkdir($uploadPath, 0777, true);
                    }
                    if (move_uploaded_file($file['tmp_name'], $uploadPath . $filename)) {
                        if (!empty($existing->photo) && file_exists(WWW_ROOT . 'img' . DS . $existing->photo)) {
                            unlink(WWW_ROOT . 'img' . DS . $existing->photo);
                        }
                        $data['photo'] = 'testimonials/' . $filename;
                    }
                } else {
                    $this->Flash->error('Invalid image type. Allowed: JPG, PNG, GIF, WEBP.');
                    unset($data['photo']);
                }
            } else {
                unset($data['photo']);
            }

            $existing = $this->Testimonials->patchEntity($existing, $data);
            if ($this->Testimonials->save($existing)) {
                $this->Flash->success('Testimonial updated successfully!');
                return $this->redirect(['action' => 'employee_index']);
            }
            $this->Flash->error('Failed to update testimonial. Please try again.');
        } else {
            $this->request = $this->request->withParsedBody($existing->toArray());
        }

        $this->set(compact('existing'));
    }

    /**
     * Admin: delete testimonial
     */
    public function admin_delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);

        $testimonial = $this->Testimonials->get($id);
        if (!$testimonial) {
            throw new NotFoundException('Invalid testimonial');
        }

        if ($this->Testimonials->delete($testimonial)) {
            if (!empty($testimonial->photo) && file_exists(WWW_ROOT . 'img' . DS . $testimonial->photo)) {
                unlink(WWW_ROOT . 'img' . DS . $testimonial->photo);
            }
            $this->Flash->success('Testimonial deleted.');
        } else {
            $this->Flash->error('Unable to delete testimonial.');
        }

        return $this->redirect(['action' => 'admin_index']);
    }

    /**
     * Employee: delete testimonial
     */
    public function employee_delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $this->checkEmployeeSession();

        $testimonial = $this->Testimonials->get($id);
        if (!$testimonial) {
            throw new NotFoundException('Invalid testimonial');
        }

        if ($this->Testimonials->delete($testimonial)) {
            if (!empty($testimonial->photo)) {
                $photoPath = WWW_ROOT . 'img' . DS . $testimonial->photo;
                if (file_exists($photoPath)) {
                    unlink($photoPath);
                }
            }
            $this->Flash->success('Testimonial deleted successfully.');
        } else {
            $this->Flash->error('Unable to delete testimonial. Please try again.');
        }

        return $this->redirect(['action' => 'employee_index']);
    }

    /**
     * Admin: toggle testimonial status (approve/unapprove)
     */
    public function admin_toggleStatus($id = null)
    {
        $this->request->allowMethod(['get', 'post']);

        if (!$id) {
            throw new NotFoundException('Invalid testimonial');
        }

        $testimonial = $this->Testimonials->get($id);
        if (!$testimonial) {
            throw new NotFoundException('Testimonial not found');
        }

        $testimonial->status = $testimonial->status ? 0 : 1;
        if ($this->Testimonials->save($testimonial)) {
            $message = $testimonial->status ? 'Testimonial approved successfully.' : 'Testimonial unapproved.';
            $this->Flash->success($message);
        } else {
            $this->Flash->error('Unable to update testimonial status.');
        }

        return $this->redirect(['action' => 'admin_index']);
    }

    /** CamelCase aliases for CakePHP 3 DashedRoute (employee-index -> employeeIndex) */
    public function adminIndex() { return $this->admin_index(); }
    public function adminAdd() { return $this->admin_add(); }
    public function adminEdit($id = null) { return $this->admin_edit($id); }
    public function adminDelete($id = null) { return $this->admin_delete($id); }
    public function adminToggleStatus($id = null) { return $this->admin_toggleStatus($id); }
    public function employeeIndex() { return $this->employee_index(); }
    public function employeeAdd() { return $this->employee_add(); }
    public function employeeEdit($id = null) { return $this->employee_edit($id); }
    public function employeeDelete($id = null) { return $this->employee_delete($id); }
}
