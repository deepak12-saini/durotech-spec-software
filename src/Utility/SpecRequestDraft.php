<?php
declare(strict_types=1);

namespace App\Utility;

final class SpecRequestDraft
{
    public const SESSION_KEY = 'SpecRequest.draft';
    public const TOKEN_KEY = 'SpecRequest.token';

    /**
     * @return array<string, mixed>
     */
    public static function empty(): array
    {
        return [
            'contact' => [
                'full_name' => '',
                'company' => '',
                'email' => '',
                'mobile' => '',
                'role' => '',
                'other_contact' => '',
            ],
            'project' => [
                'name' => '',
                'address' => '',
                'building_type' => '',
                'project_stage' => '',
                'spec_required_by' => '',
                'install_date' => '',
                'structure' => '',
                'request_type' => '',
                'notes' => '',
            ],
            'selected_areas' => [],
            'areas' => [],
            'docs' => [
                'not_available' => 0,
                'missing_reason' => '',
                'notes' => '',
                'files' => [],
            ],
            'confirm' => 0,
        ];
    }

    /**
     * @param array<string, mixed> $draft
     * @return array<string, mixed>
     */
    public static function normalize(array $draft): array
    {
        $base = self::empty();
        $draft = array_replace_recursive($base, $draft);
        $draft['selected_areas'] = array_values(array_unique(array_filter(array_map('strval', (array)($draft['selected_areas'] ?? [])))));
        $draft['areas'] = is_array($draft['areas'] ?? null) ? array_values($draft['areas']) : [];
        $draft['docs']['files'] = is_array($draft['docs']['files'] ?? null) ? array_values($draft['docs']['files']) : [];
        $draft['docs']['not_available'] = !empty($draft['docs']['not_available']) ? 1 : 0;
        $draft['confirm'] = !empty($draft['confirm']) ? 1 : 0;

        return $draft;
    }

    /**
     * @return array<string, mixed>
     */
    public static function emptyArea(string $areaKey, bool $custom = false): array
    {
        return [
            'uid' => bin2hex(random_bytes(6)),
            'area_key' => $custom ? 'custom' : $areaKey,
            'custom_label' => $custom ? 'Custom area' : '',
            'area_type' => $custom ? '' : $areaKey,
            'location' => '',
            'quantity' => '',
            'substrate' => '',
            'condition' => '',
            'finish' => '',
            'exposure' => '',
            'preferred_products' => '',
            'other_brands' => '',
            'issues' => '',
            'file' => null,
        ];
    }

    /**
     * @param array<string, mixed> $draft
     * @param string[] $selected
     * @return array<string, mixed>
     */
    public static function syncAreas(array $draft, array $selected): array
    {
        $selected = array_values(array_unique(array_filter($selected)));
        $draft['selected_areas'] = $selected;
        $existing = is_array($draft['areas'] ?? null) ? $draft['areas'] : [];
        $kept = [];
        foreach ($existing as $block) {
            if (!is_array($block)) {
                continue;
            }
            $key = (string)($block['area_key'] ?? '');
            if ($key === 'custom' || !isset(SpecRequestOptions::AREAS[$key])) {
                $kept[] = $block;
                continue;
            }
            if (in_array($key, $selected, true)) {
                $kept[] = $block;
            }
        }
        $have = [];
        foreach ($kept as $block) {
            $key = (string)($block['area_key'] ?? '');
            if ($key !== 'custom') {
                $have[$key] = true;
            }
        }
        foreach ($selected as $key) {
            if (!isset(SpecRequestOptions::AREAS[$key]) || isset($have[$key])) {
                continue;
            }
            $kept[] = self::emptyArea($key);
        }
        $draft['areas'] = $kept;

        return $draft;
    }

    public static function areaTitle(array $block): string
    {
        $key = (string)($block['area_key'] ?? '');
        if ($key === 'custom' || !isset(SpecRequestOptions::AREAS[$key])) {
            $label = trim((string)($block['custom_label'] ?? ''));

            return $label !== '' ? $label : 'Custom area';
        }

        return SpecRequestOptions::AREAS[$key];
    }
}
