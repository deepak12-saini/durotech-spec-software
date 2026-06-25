<?php
declare(strict_types=1);

namespace App\Controller\Api\V1;

use Cake\Http\Exception\NotFoundException;
use Cake\Http\Response;
use Cake\ORM\Query;

class SpecsController extends ApiAppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadModel('Mailer');
    }

    public function index(): ?Response
    {
        $this->request->allowMethod(['get']);
        $this->requireToken();

        $search = trim((string)$this->request->getQuery('search'));
        $page = max(1, (int)$this->request->getQuery('page', 1));
        $limit = (int)$this->request->getQuery('limit', 20);
        if ($limit < 1) {
            $limit = 20;
        }
        if ($limit > 100) {
            $limit = 100;
        }

        $baseQuery = $this->buildEmployeeSpecsQuery((int)$this->employeeId);
        $this->applySearchFilter($baseQuery, $search);

        $total = (int)$baseQuery->count();

        $statsQuery = $this->buildEmployeeSpecsQuery((int)$this->employeeId);
        $this->applySearchFilter($statsQuery, $search);
        $stats = $this->buildStats($statsQuery);

        $listQuery = $this->buildEmployeeSpecsQuery((int)$this->employeeId);
        $this->applySearchFilter($listQuery, $search);
        $rows = $listQuery
            ->orderDesc('Mailer.id')
            ->limit($limit)
            ->page($page)
            ->all();

        $data = [];
        foreach ($rows as $mailer) {
            $data[] = $this->formatSpecListItem($mailer);
        }

        $body = [
            'success' => true,
            'data' => $data,
            'meta' => [
                'total' => $total,
                'page' => $page,
                'limit' => $limit,
                'stats' => $stats,
            ],
        ];

        return $this->response
            ->withType('application/json')
            ->withStringBody((string)json_encode($body));
    }

    public function view($id = null): ?Response
    {
        $this->request->allowMethod(['get']);
        $this->requireToken();

        $mailer = $this->findOwnedSpec((int)$id);
        if (!$mailer) {
            throw new NotFoundException('Specification not found.');
        }

        $body = [
            'success' => true,
            'data' => $this->formatSpecDetail($mailer),
        ];

        return $this->response
            ->withType('application/json')
            ->withStringBody((string)json_encode($body));
    }

    public function pdf($id = null): ?Response
    {
        $this->request->allowMethod(['get']);
        $this->requireToken();

        $mailer = $this->findOwnedSpec((int)$id);
        if (!$mailer) {
            throw new NotFoundException('Specification not found.');
        }

        $attachment = trim((string)($mailer->pdf_attachment ?? ''));
        if ($attachment === '') {
            return $this->jsonError('PDF is not available for this specification.', 404);
        }

        $siteUrl = defined('SITEURL') ? SITEURL : '/';
        $url = rtrim($siteUrl, '/') . '/' . ltrim($attachment, '/');
        $filename = $this->buildPdfFilename($mailer);

        $body = [
            'success' => true,
            'url' => $url,
            'filename' => $filename,
        ];

        return $this->response
            ->withType('application/json')
            ->withStringBody((string)json_encode($body));
    }

    protected function buildEmployeeSpecsQuery(int $employeeId): Query
    {
        $query = $this->Mailer->find()
            ->where([
                'Mailer.employee_id' => $employeeId,
                'Mailer.type' => 3,
            ]);

        $this->applyMailerNotDeletedToQuery($query);

        if ($this->Mailer->getSchema()->getColumn('save_status')) {
            $query->andWhere([
                'OR' => [
                    ['Mailer.save_status' => 'submitted'],
                    ['Mailer.save_status IS' => null],
                ],
            ]);
        }

        return $query;
    }

    protected function applyMailerNotDeletedToQuery($query): void
    {
        if ($this->Mailer->getSchema()->getColumn('deleted_at')) {
            $query->andWhere(['Mailer.deleted_at IS' => null]);
        }
    }

    protected function applySearchFilter(Query $query, string $search): void
    {
        if ($search === '') {
            return;
        }

        $like = '%' . $search . '%';
        $query->andWhere([
            'OR' => [
                ['Mailer.tracknumber LIKE' => $like],
                ['Mailer.company LIKE' => $like],
                ['Mailer.name LIKE' => $like],
                ['Mailer.specification LIKE' => $like],
            ],
        ]);
    }

    /**
     * @return array{total:int,this_month:int,pending:int}
     */
    protected function buildStats(Query $query): array
    {
        $monthStart = date('Y-m-01');
        $rows = $query->select([
            'id',
            'date',
            'status',
            'is_review',
            'pdf_attachment',
            'save_status',
        ])->all();

        $total = 0;
        $thisMonth = 0;
        $pending = 0;

        foreach ($rows as $row) {
            $total++;
            $date = (string)($row->date ?? '');
            if ($date !== '' && $date >= $monthStart) {
                $thisMonth++;
            }
            if ($this->deriveStatus($row) === 'Pending') {
                $pending++;
            }
        }

        return [
            'total' => $total,
            'this_month' => $thisMonth,
            'pending' => $pending,
        ];
    }

  /**
   * @return \Cake\Datasource\EntityInterface|null
   */
    protected function findOwnedSpec(int $id)
    {
        if ($id <= 0) {
            return null;
        }

        $query = $this->Mailer->find()
            ->where([
                'Mailer.id' => $id,
                'Mailer.employee_id' => (int)$this->employeeId,
                'Mailer.type' => 3,
            ]);

        $this->applyMailerNotDeletedToQuery($query);

        return $query->first();
    }

    /**
     * @param \Cake\Datasource\EntityInterface $mailer
     * @return array<string, mixed>
     */
    protected function formatSpecListItem($mailer): array
    {
        $company = trim((string)($mailer->company ?? ''));
        $name = trim((string)($mailer->name ?? ''));

        return [
            'id' => (int)$mailer->id,
            'track_number' => (string)($mailer->tracknumber ?? ''),
            'project' => $company !== '' ? $company : $name,
            'client' => $company !== '' ? $company : $name,
            'status' => $this->deriveStatus($mailer),
            'date' => $this->formatDate($mailer->date ?? null),
        ];
    }

    /**
     * @param \Cake\Datasource\EntityInterface $mailer
     * @return array<string, mixed>
     */
    protected function formatSpecDetail($mailer): array
    {
        $company = trim((string)($mailer->company ?? ''));
        $name = trim((string)($mailer->name ?? ''));
        $project = $company !== '' ? $company : $name;

        return [
            'id' => (int)$mailer->id,
            'track_number' => (string)($mailer->tracknumber ?? ''),
            'project' => $project,
            'project_full' => $project,
            'client' => $company !== '' ? $company : $name,
            'address' => (string)($mailer->address ?? ''),
            'email' => (string)($mailer->email ?? ''),
            'spec_type' => (string)($mailer->specification ?? ''),
            'status' => $this->deriveStatus($mailer),
            'date' => $this->formatDate($mailer->date ?? null),
            'has_pdf' => trim((string)($mailer->pdf_attachment ?? '')) !== '',
        ];
    }

    /**
     * @param \Cake\Datasource\EntityInterface $mailer
     */
    protected function deriveStatus($mailer): string
    {
        if ($this->Mailer->getSchema()->getColumn('save_status')) {
            $saveStatus = (string)($mailer->save_status ?? '');
            if ($saveStatus === 'draft') {
                return 'Draft';
            }
        }

        $status = (int)($mailer->status ?? 0);
        $isReview = (int)($mailer->is_review ?? 0);

        if ($isReview === 1 && $status === 1) {
            return 'Approved';
        }

        if (!empty($mailer->pdf_attachment) && $isReview === 1) {
            return 'Approved';
        }

        return 'Pending';
    }

    /**
     * @param mixed $date
     */
    protected function formatDate($date): string
    {
        if ($date === null || $date === '') {
            return '';
        }

        $timestamp = is_object($date) && method_exists($date, 'format')
            ? strtotime($date->format('Y-m-d'))
            : strtotime((string)$date);

        if ($timestamp === false) {
            return (string)$date;
        }

        return date('Y-m-d', $timestamp);
    }

    /**
     * @param \Cake\Datasource\EntityInterface $mailer
     */
    protected function buildPdfFilename($mailer): string
    {
        $mailerId = (int)($mailer->id ?? 0);
        $tracknumber = (string)($mailer->tracknumber ?? '');
        $pdfBaseName = $mailerId . '-' . $tracknumber;
        $pdfBaseName = preg_replace('/[^a-zA-Z0-9_\-]/', '_', $pdfBaseName) ?? 'spec';
        $pdfBaseName = preg_replace('/_+/', '_', $pdfBaseName) ?? 'spec';
        $pdfBaseName = trim($pdfBaseName, '_');

        if ($pdfBaseName === '') {
            $pdfBaseName = 'spec_' . $mailerId;
        }

        return $pdfBaseName . '.pdf';
    }
}
