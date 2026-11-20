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
        $authError = $this->requireToken();
        if ($authError !== null) {
            return $authError;
        }

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
        $totalPages = $total > 0 ? (int)ceil($total / $limit) : 1;
        if ($page > $totalPages) {
            $page = $totalPages;
        }

        $statsQuery = $this->buildEmployeeSpecsQuery((int)$this->employeeId);
        $this->applySearchFilter($statsQuery, $search);
        $stats = $this->buildStats($statsQuery);

        $listQuery = $this->buildEmployeeSpecsQuery((int)$this->employeeId);
        $this->applySearchFilter($listQuery, $search);
        $this->containSpecRelations($listQuery);
        $rows = $listQuery
            ->orderDesc('Mailer.id')
            ->limit($limit)
            ->page($page)
            ->all();

        $data = [];
        foreach ($rows as $mailer) {
            $data[] = $this->formatSpecListItem($mailer);
        }

        $from = $total === 0 ? 0 : (($page - 1) * $limit) + 1;
        $to = $total === 0 ? 0 : min($total, $page * $limit);

        $body = [
            'success' => true,
            'data' => $data,
            'meta' => [
                'total' => $total,
                'page' => $page,
                'limit' => $limit,
                'total_pages' => $totalPages,
                'has_prev' => $page > 1,
                'has_next' => $page < $totalPages,
                'from' => $from,
                'to' => $to,
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
        $authError = $this->requireToken();
        if ($authError !== null) {
            return $authError;
        }

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
        $authError = $this->requireToken();
        if ($authError !== null) {
            return $authError;
        }

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
        $this->containSpecRelations($query);

        return $query->first();
    }

    protected function containSpecRelations(Query $query): void
    {
        $query->contain([
            'SpecUsearea' => function (Query $q) {
                return $q->orderAsc('SpecUsearea.id');
            },
            'MailerComment' => function (Query $q) {
                return $q->orderAsc('MailerComment.id');
            },
        ]);
    }

    /**
     * @param \Cake\Datasource\EntityInterface $mailer
     * @return array<string, mixed>
     */
    protected function formatSpecListItem($mailer): array
    {
        return $this->formatSpecDetail($mailer);
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
        $typeId = (int)($mailer->type ?? 0);
        $useAreaFlag = (int)($mailer->use_area ?? 0);

        return [
            'id' => (int)$mailer->id,
            'track_number' => (string)($mailer->tracknumber ?? ''),
            'name' => $name,
            'email' => (string)($mailer->email ?? ''),
            'company' => $company,
            'address' => (string)($mailer->address ?? ''),
            'specification' => (string)($mailer->specification ?? ''),
            'created' => $this->formatDateTime($mailer->created ?? null),
            'date' => $this->formatDate($mailer->date ?? null),
            'project' => $project,
            'project_full' => $project,
            'client' => $company !== '' ? $company : $name,
            'mailer_type_id' => $typeId,
            'mailer_type' => $this->mailerTypeLabel($typeId),
            'subject' => (string)($mailer->subject ?? ''),
            'spec_type' => $useAreaFlag === 0 ? 'With Warranty Column' : 'Without Warranty Column',
            'spec_type_code' => $useAreaFlag === 0 ? 1 : 0,
            'status' => $this->deriveStatus($mailer),
            'has_pdf' => trim((string)($mailer->pdf_attachment ?? '')) !== '',
            'use_areas' => $this->formatUseAreas($mailer),
            'comments' => $this->formatComments($mailer),
        ];
    }

    /**
     * @param \Cake\Datasource\EntityInterface $mailer
     * @return array<int, array<string, mixed>>
     */
    protected function formatUseAreas($mailer): array
    {
        $rows = $mailer->spec_usearea ?? $mailer->spec_useareas ?? [];
        $grouped = [];
        foreach ($rows as $row) {
            $title = trim((string)($row->title ?? ''));
            $key = $title !== '' ? $title : ('section-' . (string)($row->types ?? '0'));
            if (!isset($grouped[$key])) {
                $grouped[$key] = [
                    'title' => $title,
                    'products' => [],
                ];
            }
            $grouped[$key]['products'][] = [
                'id' => (int)($row->id ?? 0),
                'serial' => (string)($row->serial ?? ''),
                'product_type' => (string)($row->coverage ?? ''),
                'product' => (string)($row->product ?? ''),
                'mft' => (string)($row->coverage_by_pack ?? ''),
                'warranty_period' => (string)($row->Warranty ?? $row->warranty ?? ''),
            ];
        }

        return array_values($grouped);
    }

    /**
     * @param \Cake\Datasource\EntityInterface $mailer
     * @return array<int, array<string, mixed>>
     */
    protected function formatComments($mailer): array
    {
        $rows = $mailer->mailer_comment ?? $mailer->mailer_comments ?? [];
        $out = [];
        foreach ($rows as $row) {
            $text = trim((string)($row->comment ?? ''));
            if ($text === '') {
                continue;
            }
            $out[] = [
                'id' => (int)($row->id ?? 0),
                'comment' => $text,
            ];
        }

        return $out;
    }

    protected function mailerTypeLabel(int $typeId): string
    {
        $labels = [
            1 => 'INSTALLATION OF DUROMASTIC P-15 WATERPROOFING MEMBRANE',
            2 => 'Waterproofing Specification – Wet area shower',
            3 => 'External Liquid WPM',
        ];

        return $labels[$typeId] ?? '';
    }

    /**
     * @param mixed $value
     */
    protected function formatDateTime($value): string
    {
        if ($value === null || $value === '') {
            return '';
        }
        if (is_object($value) && method_exists($value, 'format')) {
            return $value->format('Y-m-d H:i:s');
        }
        $ts = strtotime((string)$value);

        return $ts === false ? (string)$value : date('Y-m-d H:i:s', $ts);
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
