<?php
declare(strict_types=1);

namespace App\Controller\Api\V1;

use App\Controller\AppController;
use Cake\Event\EventInterface;
use Cake\Http\Response;
use Cake\I18n\FrozenTime;

/**
 * Base controller for JSON API v1 (employee mobile app).
 */
class ApiAppController extends AppController
{
    /** @var int|null */
    protected $employeeId;

    /** @var \App\Model\Entity\Employee|null */
    protected $employee;

    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('RequestHandler');
        $this->viewBuilder()->setClassName('Json');
    }

    public function beforeFilter(EventInterface $event): ?Response
    {
        $this->callConstants();
        $this->applyCorsHeaders();

        if (strtoupper($this->request->getMethod()) === 'OPTIONS') {
            return $this->response
                ->withStatus(200)
                ->withType('application/json')
                ->withStringBody((string)json_encode(['success' => true]));
        }

        return null;
    }

    protected function applyCorsHeaders(): void
    {
        $this->response = $this->response
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS')
            ->withHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Api-Token');
    }

    /**
     * @return array<string, mixed>
     */
    protected function formatEmployee($employee): array
    {
        $name = (string)($employee->name ?? '');

        return [
            'id' => (int)$employee->id,
            'name' => $name,
            'username' => $name,
            'email' => (string)($employee->email ?? ''),
            'role' => 'employee',
        ];
    }

    protected function requireToken(): ?Response
    {
        $token = $this->extractBearerToken();
        if ($token === null) {
            return $this->jsonError('Missing or invalid authorization token.', 401);
        }

        $this->loadModel('ApiTokens');

        $row = $this->ApiTokens->find()
            ->contain(['Employee'])
            ->where(['ApiTokens.token' => $token])
            ->first();

        if (!$row || !$row->employee) {
            return $this->jsonError('Invalid or expired token.', 401);
        }

        $expiresAt = $row->expires_at;
        if ($expiresAt instanceof FrozenTime) {
            if ($expiresAt->isPast()) {
                $this->ApiTokens->delete($row);
                return $this->jsonError('Invalid or expired token.', 401);
            }
        } elseif (strtotime((string)$expiresAt) < time()) {
            $this->ApiTokens->delete($row);
            return $this->jsonError('Invalid or expired token.', 401);
        }

        if ((int)$row->employee->is_active === 0) {
            return $this->jsonError('Account is not active.', 401);
        }

        $this->employeeId = (int)$row->employee->id;
        $this->employee = $row->employee;

        return null;
    }

    protected function extractBearerToken(): ?string
    {
        $candidates = [
            (string)$this->request->getHeaderLine('Authorization'),
            (string)$this->request->getHeaderLine('X-Api-Token'),
            (string)($_SERVER['HTTP_AUTHORIZATION'] ?? ''),
            (string)($_SERVER['REDIRECT_HTTP_AUTHORIZATION'] ?? ''),
        ];

        foreach ($candidates as $header) {
            if ($header === '') {
                continue;
            }

            if (preg_match('/^Bearer\s+(\S+)$/i', $header, $matches)) {
                return $matches[1];
            }

            if (preg_match('/^\S+$/', $header)) {
                return $header;
            }
        }

        return null;
    }

    /**
     * @param array<string, mixed> $payload
     */
    protected function jsonResponse(array $payload, int $status = 200): Response
    {
        $data = array_merge(['success' => true], $payload);
        $data['_serialize'] = array_keys($data);
        $data['_serialize'] = array_values(array_diff($data['_serialize'], ['_serialize']));

        $this->set($data);

        return $this->response->withStatus($status)->withType('application/json');
    }

    /**
     * @param array<string, mixed> $errors
     */
    protected function jsonError(string $message, int $status = 400, array $errors = []): Response
    {
        $payload = [
            'success' => false,
            'message' => $message,
        ];

        if ($errors !== []) {
            $payload['errors'] = $errors;
        }

        return $this->response
            ->withStatus($status)
            ->withType('application/json')
            ->withStringBody((string)json_encode($payload));
    }
}
