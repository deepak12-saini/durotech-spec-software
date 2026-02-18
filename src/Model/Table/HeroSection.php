<?php
class HeroSection extends AppModel {
    public $useTable = 'hero_sections'; // optional if naming matches
    public $name = 'HeroSection';

    public $validate = [
        'title' => [
            'rule' => 'notEmpty',
            'message' => 'Please enter a title'
        ],
        'video' => [
            'rule' => 'notEmpty',
            'message' => 'Please upload a video'
        ]
    ];
}
