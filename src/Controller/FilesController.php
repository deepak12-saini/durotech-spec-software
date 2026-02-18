<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Response;
use Cake\Routing\Router;

/**
 * Serves uploaded files (datasheets, MSDS, VOC, etc.) from webroot/files/.
 * Used when product datasheet/PDF URLs like /files/datasheets/filename.pdf
 * are requested (CakePHP routes these to this controller).
 */
class FilesController extends AppController
{
    /**
     * Allowed subdirectories under webroot/files/ that can be served.
     */
    protected const ALLOWED_FOLDERS = ['datasheets', 'vocsheets', 'colour_charts'];

    public function beforeFilter(\Cake\Event\EventInterface $event): ?Response
    {
        parent::beforeFilter($event);
        // Allow unauthenticated GET for file serving (datasheets, etc.)
        return null;
    }

    /**
     * Serve a file from webroot/files/{folder}/{name}.
     * Prevents path traversal; only allows files in allowed subfolders.
     *
     * @param string|null $folder Subfolder name (e.g. datasheets, vocsheets).
     * @param string|null $name File name (e.g. document.pdf).
     * @return \Cake\Http\Response|null
     */
    public function index(?string $folder = null, ?string $name = null): ?Response
    {
        $this->request->allowMethod(['GET']);

        $pass = $this->request->getParam('pass', []);
        // URL /files/datasheets/file.pdf -> pass may be ['datasheets', 'file.pdf'] or action is 'datasheets' with pass ['file.pdf']
        if ($folder === null && !empty($pass[0])) {
            $folder = $pass[0];
        }
        if ($name === null && !empty($pass[1])) {
            $name = $pass[1];
        }
        if ($folder === null || $name === null || $name === '') {
            return $this->response->withStatus(404);
        }

        if (!in_array($folder, self::ALLOWED_FOLDERS, true)) {
            return $this->response->withStatus(403);
        }

        $safeName = basename($name);
        if ($safeName !== $name || strpos($name, '..') !== false) {
            return $this->response->withStatus(400);
        }

        $filePath = WWW_ROOT . 'files' . DS . $folder . DS . $safeName;
        if (!is_file($filePath)) {
            return $this->response->withStatus(404);
        }

        $mime = $this->_getMimeType($safeName);
        $this->response = $this->response->withHeader('Content-Type', $mime);
        $this->response = $this->response->withHeader('Content-Disposition', 'inline; filename="' . $safeName . '"');
        $this->response = $this->response->withFile($filePath, ['download' => false]);

        return $this->response;
    }

    /**
     * Action for URL /files/datasheets/filename.pdf (DashedRoute maps to datasheets action).
     */
    public function datasheets(?string $name = null): ?Response
    {
        $this->viewBuilder()->setLayout(false);
        $this->autoRender = false;
        $name = $name ?? $this->request->getParam('pass.0');
        return $this->_serveFile('datasheets', $name);
    }

    /**
     * Action for URL /files/vocsheets/filename.pdf
     */
    public function vocsheets(?string $name = null): ?Response
    {
        $this->viewBuilder()->setLayout(false);
        $this->autoRender = false;
        $name = $name ?? $this->request->getParam('pass.0');
        return $this->_serveFile('vocsheets', $name);
    }

    /**
     * Action for URL /files/colour_charts/filename
     */
    public function colourCharts(?string $name = null): ?Response
    {
        $this->viewBuilder()->setLayout(false);
        $this->autoRender = false;
        $name = $name ?? $this->request->getParam('pass.0');
        return $this->_serveFile('colour_charts', $name);
    }

    /**
     * Stream a file from webroot/files/{folder}/{name}.
     */
    protected function _serveFile(string $folder, ?string $name): ?Response
    {
        $this->request->allowMethod(['GET']);

        if ($name === null || $name === '') {
            return $this->response->withStatus(404);
        }

        $safeName = basename($name);
        if ($safeName !== $name || strpos($name, '..') !== false) {
            return $this->response->withStatus(400);
        }

        $filePath = WWW_ROOT . 'files' . DS . $folder . DS . $safeName;
        if (!is_file($filePath)) {
            return $this->response->withStatus(404);
        }

        $mime = $this->_getMimeType($safeName);
        $this->response = $this->response->withHeader('Content-Type', $mime);
        $this->response = $this->response->withHeader('Content-Disposition', 'inline; filename="' . $safeName . '"');
        $this->response = $this->response->withFile($filePath, ['download' => false]);

        return $this->response;
    }

    protected function _getMimeType(string $filename): string
    {
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        $map = [
            'pdf' => 'application/pdf',
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
        ];
        return $map[$ext] ?? 'application/octet-stream';
    }
}
