<?php
/**
 * @var \App\View\AppView $this
 * @var string $tracknumber
 * @var bool $isEdit
 */
$formAction = $aispecFormAction ?? ['action' => 'admin_send'];
$listAction = $aispecListAction ?? 'admin_index';
echo $this->element('AiSpecs/form', [
	'formTitle' => 'Create materials matrix',
	'formAction' => $formAction,
	'listAction' => $listAction,
	'tracknumber' => $tracknumber,
	'aiSpec' => null,
	'isEdit' => false,
]);
