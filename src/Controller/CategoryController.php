<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Response;

/**
 * Category controller – forwards /category/:slug to Products::index for product listing by category.
 * Exists so URLs like /category/tapes-reinforcement-fabric do not hit a missing controller.
 */
class CategoryController extends AppController
{
    /**
     * Forward to product listing with category slug.
     * URL: /category/:slug or /category/part1/part2 (slug built from pass)
     */
    public function index(): ?Response
    {
        $pass = $this->request->getParam('pass');
        $slug = is_array($pass) ? implode('/', $pass) : (string)$pass;

        return $this->redirect([
            'controller' => 'Products',
            'action' => 'index',
            'slug' => $slug,
        ]);
    }
}
