<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Response;
use Cake\Routing\Router;

/**
 * Category controller – forwards /category/:slug to Products::index for product listing by category.
 * Exists so URLs like /category/tapes-reinforcement-fabric do not hit a missing controller.
 */
class CategoryController extends AppController
{
    /**
     * Forward to product listing with category slug.
     * URL: /category/:slug or /category/part1/part2 (slug built from pass).
     * Redirect uses query string ?slug=... so the request hits Products::index (not product detail).
     */
    public function index(): ?Response
    {
        $pass = $this->request->getParam('pass');
        $slug = is_array($pass) ? implode('/', array_filter($pass, 'strlen')) : (string)$pass;
        $slug = trim((string)$slug, '/');

        $indexUrl = Router::url(['controller' => 'Products', 'action' => 'index'], true);
        $url = $indexUrl . (strpos($indexUrl, '?') !== false ? '&' : '?') . 'slug=' . rawurlencode($slug);

        return $this->redirect($url);
    }
}
