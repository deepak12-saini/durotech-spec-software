<?php
declare(strict_types=1);

namespace App\Utility;

use Cake\Log\Log;
use Cake\Mailer\Email;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;

/**
 * Sends product warranty approval emails to customers.
 */
final class ProductWarrantyCustomerNotifier
{
    /**
     * Email approved certificate PDF + portal link to the customer on file.
     *
     * @return bool True if email was sent; false if skipped or failed.
     */
    public static function sendApprovedCertificateEmail(int $requestId, string $portalToken): bool
    {
        try {
            $table = TableRegistry::getTableLocator()->get('ProductWarrantyRequests');
            $entity = $table->get($requestId);
        } catch (\Throwable $e) {
            Log::error('ProductWarrantyCustomerNotifier: request not found id ' . $requestId);

            return false;
        }

        $log = $entity->toArray();
        $toEmail = trim((string)($log['email'] ?? ''));
        if ($toEmail === '' || !filter_var($toEmail, FILTER_VALIDATE_EMAIL)) {
            Log::warning('ProductWarrantyCustomerNotifier: no valid customer email for request id ' . $requestId);

            return false;
        }

        $pdfBinary = ProductWarrantyPdfGenerator::generatePdfBinaryForRequest($requestId);
        if (!is_string($pdfBinary) || $pdfBinary === '') {
            Log::error('ProductWarrantyCustomerNotifier: PDF generation failed for id ' . $requestId);

            return false;
        }

        $filename = ProductWarrantyPdfGenerator::certificateFilename($requestId, $log);
        $siteName = defined('SITENAME') ? (string)SITENAME : 'Durotech Industries';
        $portalUrl = Router::url([
            'controller' => 'Fronts',
            'action' => 'productWarrantyV2Portal',
            $portalToken,
        ], true);

        try {
            [$from, $fromName] = EmailFrom::resolve($siteName);
            $smtpAuthFrom = EmailFrom::smtpAuthAddressIfAllowed();
            if ($smtpAuthFrom !== null) {
                $from = $smtpAuthFrom;
            }

            $mail = new Email('default');
            $mail->viewBuilder()
                ->setClassName('App\View\AppView')
                ->setTemplate('product_warranty_customer_approved');
            $mail->setFrom([$from => $fromName])
                ->setTo($toEmail)
                ->setSubject($siteName . ' | Your Product Warranty Certificate')
                ->setEmailFormat('html')
                ->setViewVars([
                    'siteName' => $siteName,
                    'contractName' => trim((string)($log['contract_name'] ?? '')),
                    'product' => trim((string)($log['product'] ?? '')),
                    'portalUrl' => $portalUrl,
                ])
                ->setAttachments([
                    $filename => [
                        'data' => $pdfBinary,
                        'mimetype' => 'application/pdf',
                    ],
                ])
                ->send();

            return true;
        } catch (\Throwable $e) {
            Log::error('ProductWarrantyCustomerNotifier: send failed for id ' . $requestId . ': ' . $e->getMessage());

            return false;
        }
    }
}
