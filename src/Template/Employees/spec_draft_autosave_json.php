<?php
echo json_encode(isset($response) ? $response : ['success' => false, 'error' => 'Unknown']);
