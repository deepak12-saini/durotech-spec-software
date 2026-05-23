<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AiSpec $aiSpec
 * @var string $tracknumber
 * @var bool $isEdit
 */
$formAction = $aispecFormAction ?? ['action' => 'admin_edit', $aiSpec->id];
$listAction = $aispecListAction ?? 'admin_index';
echo $this->element('AiSpecs/form', [
	'formTitle' => 'Edit materials matrix',
	'formAction' => $formAction,
	'listAction' => $listAction,
	'tracknumber' => $tracknumber,
	'aiSpec' => $aiSpec,
	'isEdit' => true,
]);
