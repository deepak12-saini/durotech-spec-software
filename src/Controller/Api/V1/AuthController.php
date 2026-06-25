<?php
declare(strict_types=1);

namespace App\Controller\Api\V1;

use Cake\Http\Response;
use Cake\I18n\FrozenTime;

class AuthController extends ApiAppController
{
    public function login(): ?Response
    {
        $this->request->allowMethod(['post']);

        $data = $this->request->getData();
        if (empty($data)) {
            $body = $this->request->input('json_decode', true);
            if (is_array($body)) {
                $data = $body;
            }
        }

        $username = trim((string)($data['username'] ?? ''));
        $password = (string)($data['password'] ?? '');

        if ($username === '' || $password === '') {
            return $this->jsonError('Username and password are required.', 422);
        }

        $this->loadModel('Employee');
        $employee = $this->Employee->find()
            ->where([
                'name' => $username,
                'password' => md5($password),
            ])
            ->first();

        if (!$employee) {
            return $this->jsonError('Wrong username or password.', 401);
        }

        if ((int)$employee->is_active === 0) {
            return $this->jsonError('Your account is not active.', 403);
        }

        $this->loadModel('LoginHistory');
        $loginHistory = $this->LoginHistory->newEntity([
            'user_id' => (int)$employee->id,
            'role' => 'Employee',
            'logintime' => date('Y-m-d H:i:s'),
        ]);
        $this->LoginHistory->save($loginHistory);

        $token = bin2hex(random_bytes(32));
        $expiresAt = FrozenTime::now()->addDays(30);

        $this->loadModel('ApiTokens');
        $apiToken = $this->ApiTokens->newEntity([
            'employee_id' => (int)$employee->id,
            'token' => $token,
            'expires_at' => $expiresAt,
            'created' => FrozenTime::now(),
        ]);
        $this->ApiTokens->save($apiToken);

        $body = [
            'success' => true,
            'token' => $token,
            'user' => $this->formatEmployee($employee),
        ];

        return $this->response
            ->withType('application/json')
            ->withStringBody((string)json_encode($body));
    }

    public function me(): ?Response
    {
        $this->request->allowMethod(['get']);
        $authError = $this->requireToken();
        if ($authError !== null) {
            return $authError;
        }

        $body = [
            'success' => true,
            'user' => $this->formatEmployee($this->employee),
        ];

        return $this->response
            ->withType('application/json')
            ->withStringBody((string)json_encode($body));
    }

    public function logout(): ?Response
    {
        $this->request->allowMethod(['post']);

        $header = (string)$this->request->getHeaderLine('Authorization');
        if (preg_match('/^Bearer\s+(\S+)$/i', $header, $matches)) {
            $this->loadModel('ApiTokens');
            $this->ApiTokens->deleteAll(['token' => $matches[1]]);
        }

        $body = [
            'success' => true,
            'message' => 'Logged out.',
        ];

        return $this->response
            ->withType('application/json')
            ->withStringBody((string)json_encode($body));
    }
}
