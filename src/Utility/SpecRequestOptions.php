<?php
declare(strict_types=1);

namespace App\Utility;

final class SpecRequestOptions
{
    /** @var array<string, string> */
    public const ROLES = [
        'architect' => 'Architect / specifier',
        'builder' => 'Builder',
        'waterproofing_contractor' => 'Waterproofing contractor',
        'engineer' => 'Engineer / consultant',
        'owner' => 'Owner / developer',
        'distributor' => 'Distributor',
    ];

    /** @var array<string, string> */
    public const BUILDING_TYPES = [
        'house_townhouse' => 'House / townhouse',
        'apartments' => 'Apartments',
        'commercial' => 'Commercial',
        'industrial' => 'Industrial',
        'other' => 'Other',
    ];

    /** @var array<string, string> */
    public const PROJECT_STAGES = [
        'design_documentation' => 'Design / documentation',
        'tender' => 'Tender',
        'under_construction' => 'Under construction',
        'repair_refurbishment' => 'Repair / refurbishment',
    ];

    /** @var array<string, string> */
    public const STRUCTURES = [
        'new_build' => 'New build',
        'existing_refurbishment' => 'Existing / refurbishment',
        'not_sure' => 'Not sure',
    ];

    /** @var array<string, string> */
    public const REQUEST_TYPES = [
        'full_project' => 'Full project specification',
        'single_area' => 'Single area specification',
        'product_substitution' => 'Product substitution',
        'revision' => 'Revision to existing specification',
    ];

    /** @var array<string, string> */
    public const AREAS = [
        'wet_areas' => 'Bathrooms / wet areas',
        'balconies_terraces' => 'Balconies / terraces',
        'roof' => 'Roof',
        'podium' => 'Podium',
        'basement' => 'Basement / retaining walls',
        'pools' => 'Pools',
        'water_tanks' => 'Water tanks',
        'facade_joints' => 'Facade / movement joints',
        'floor_coatings' => 'Floor coatings',
        'planter_boxes' => 'Planter boxes',
    ];

    /** @var array<string, string> */
    public const SUBSTRATES = [
        'concrete' => 'Concrete',
        'fibre_cement' => 'Fibre cement / screed',
        'timber' => 'Timber',
        'masonry' => 'Masonry',
        'existing_membrane' => 'Existing membrane',
        'other' => 'Other',
        'unknown' => 'Unknown',
    ];

    /** @var array<string, string> */
    public const CONDITIONS = [
        'sound' => 'Sound',
        'cracked' => 'Cracked',
        'damp' => 'Damp',
        'unknown' => 'Unknown',
    ];

    /** @var array<string, string> */
    public const FINISHES = [
        'tiles' => 'Tiles',
        'screed' => 'Screed',
        'paint' => 'Paint',
        'exposed' => 'Exposed',
        'other' => 'Other',
    ];

    /** @var array<string, string> */
    public const EXPOSURES = [
        'external_uv' => 'External — weather & UV',
        'internal_wet' => 'Internal wet areas',
        'internal_dry' => 'Internal dry',
        'immersed' => 'Immersed / tank',
    ];

    /** @var array<string, string> */
    public const REQUEST_STATUSES = [
        'new_request' => 'New request',
        'in_review' => 'In review',
        'clarification' => 'Clarification needed',
        'drafting' => 'Drafting',
        'issued' => 'Issued',
    ];

    public static function label(array $map, $key): string
    {
        $k = (string)$key;

        return $map[$k] ?? $k;
    }
}
