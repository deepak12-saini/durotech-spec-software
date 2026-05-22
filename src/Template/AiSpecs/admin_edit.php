<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AiSpec $aiSpec
 * @var string $tracknumber
 * @var bool $isEdit
 */
echo $this->element('AiSpecs/form', [
	'formTitle' => 'Edit materials matrix',
	'formAction' => ['action' => 'admin_edit', $aiSpec->id],
	'tracknumber' => $tracknumber,
	'aiSpec' => $aiSpec,
	'isEdit' => true,
]);
