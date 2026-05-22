<?php
/**
 * @var \App\View\AppView $this
 * @var string $tracknumber
 * @var bool $isEdit
 */
echo $this->element('AiSpecs/form', [
	'formTitle' => 'Create materials matrix',
	'formAction' => ['action' => 'admin_send'],
	'tracknumber' => $tracknumber,
	'aiSpec' => null,
	'isEdit' => false,
]);
