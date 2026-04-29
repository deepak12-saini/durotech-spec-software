<?php
$max = 20; // Peak value
$monthToNum = [
    'JAN' => '01', 'FEB' => '02', 'MAR' => '03', 'APR' => '04',
    'MAY' => '05', 'JUN' => '06', 'JUL' => '07', 'AUG' => '08',
    'SEP' => '09', 'OCT' => '10', 'NOV' => '11', 'DEC' => '12'
];
?>

<style>
    /* Dashboard background to match sidebar theme */
    .main-content-inner {
        background: #f2f2f2;
        min-height: 100vh;
        padding-bottom: 24px;
    }

    /* Two cards per row on desktop */
    .monthly-cards-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 18px;
        padding: 0 10px 10px;
        align-items: stretch;
    }

    @media (max-width: 768px) {
        .monthly-cards-grid {
            grid-template-columns: 1fr;
        }
    }

h2.page-title {
    font-weight: 600;
    margin-bottom: 20px;
    text-align: center;
    /* color: #1c1c1e; */
}

    /* Make whole card clickable */
    .monthly-card-link {
        display: block;
        height: 100%;
        text-decoration: none;
        color: inherit;
        cursor: pointer;
    }

    .monthly-card-link .card {
        height: 100%;
    }

/* .card {
    background: #fff;
    border-radius: 16px;
    border: 2px solid #ddd;
    padding: 20px;
    box-shadow: 0 8px 30px rgba(0,0,0,0.06);
    margin-bottom: 16px;
    width: 60%;
    margin-left: auto;
    margin-right: auto;
} */

    .card {
    background: #fff;
    border-radius: 16px;
    border: 1px solid #e0e0e0; /* softer border */
    padding: 20px;
    width: 100%;

    /* Grid handles spacing; keep margin from messing layout */
    margin-bottom: 0;

    /* Multi-layer shadow for depth */
    box-shadow: 
        0 1px 3px rgba(0,0,0,0.12),   /* small shadow */
        0 4px 6px rgba(0,0,0,0.08),   /* medium shadow */
        0 10px 20px rgba(0,0,0,0.05); /* big soft shadow */

    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

/* Hover effect: card “lifts” */
.card:hover {
    transform: translateY(-4px); /* slightly lift */
    box-shadow: 
        0 4px 12px rgba(0,0,0,0.15),
        0 8px 24px rgba(0,0,0,0.1),
        0 16px 48px rgba(0,0,0,0.08);
}

.card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 12px;
}

.month {
    font-size: 14px;
    font-weight: 600;
    color: #1c1c1e;
    letter-spacing: 1px;
    padding: 6px 12px;
    border-radius: 12px;
    background: #f2f3f7;
    transition: all 0.25s ease;
    cursor: default;
}

.month:hover {
    background: #e8ebf3;
    transform: scale(1.05);
}

.count {
    font-size: 32px;
    font-weight: 700;
}

.count span {
    font-size: 14px;
    color: #777;
}

/* Power bar container */
.power-bar {
    height: 10px; /* small graph */
    background: #eee;
    border-radius: 12px;
    display: flex;
    overflow: hidden;
    margin-top: 8px;
}

.power-segment {
    height: 100%;
}

/* Individual segments */
.power-segment {
    flex: 1; /* Equal width */
    transition: opacity 0.3s ease;
    background: #ddd;
    position: relative;
}

/* Inactive segment */
.power-segment.inactive {
    background: #ddd;
}

/* Active segments colors */
.power-segment.red .seg-fill { background: #ff3b30; }
.power-segment.yellow .seg-fill { background: #ffcc00; }
.power-segment.green .seg-fill { background: #34c759; }

.seg-fill {
    height: 100%;
    width: 0%;
    transition: width 0.3s ease;
}

.scale {
    font-size: 12px;
    color: #888;
    text-align: right;
    margin-top: 6px;
}

.filter-dropdown {
    text-align: center;
    margin-bottom: 20px;
}

.filter-dropdown form {
    display: inline-flex;
    gap: 10px;
    flex-wrap: wrap;
    justify-content: center;
    align-items: center;
}

.filter-dropdown select {
    padding: 6px 12px;
    border-radius: 8px;
    border: 1px solid #ccc;
    font-size: 14px;
    cursor: pointer;
}
</style>

<h2 class="page-title">
    <?= h($employeeDisplayName ?? 'Employee') ?> – Monthly Specs (<?= h($selectedYear) ?>)
</h2>

<div class="filter-dropdown">
    <form id="monthlySpecsFilterForm" method="get">
        <select id="timeFilter" name="filter" onchange="filterSpecs()">
            <option value="today" <?= $filter === 'today' ? 'selected' : '' ?>>Today</option>
            <option value="month" <?= $filter === 'month' ? 'selected' : '' ?>>This Month</option>
            <option value="year" <?= $filter === 'year' ? 'selected' : '' ?>>This Year</option>
        </select>

        <select id="yearFilter" name="year" onchange="filterSpecs()">
            <?php foreach (($availableYears ?? []) as $yearOption): ?>
                <option value="<?= (int)$yearOption ?>" <?= (int)$selectedYear === (int)$yearOption ? 'selected' : '' ?>>
                    <?= (int)$yearOption ?>
                </option>
            <?php endforeach; ?>
        </select>
    </form>
</div>

<div class="monthly-cards-grid">
    <?php foreach ($monthlySpecs as $month => $specCount): ?>
    <?php $percent = min(($specCount / $max) * 100, 100); ?>
    <?php
        $monthNum = $monthToNum[$month] ?? null;
        $cardUrl = SITEURL . 'employees/index';
        if ($filter === 'today') {
            $today = date('Y-m-d');
            $cardUrl .= '?date_from=' . $today . '&date_to=' . $today;
        } elseif (!empty($monthNum) && !empty($selectedYear)) {
            $lastDay = cal_days_in_month(CAL_GREGORIAN, (int)$monthNum, (int)$selectedYear);
            $dateFrom = $selectedYear . '-' . $monthNum . '-01';
            $dateTo = $selectedYear . '-' . $monthNum . '-' . str_pad((string)$lastDay, 2, '0', STR_PAD_LEFT);
            $cardUrl .= '?date_from=' . $dateFrom . '&date_to=' . $dateTo;
        } elseif ($filter === 'year' && !empty($selectedYear)) {
            $cardUrl .= '?date_from=' . $selectedYear . '-01-01&date_to=' . $selectedYear . '-12-31';
        }

        // Build a small 3-part progress bar (red/yellow/green)
        $segMax = 33.33;
        $fill1 = min($percent, $segMax);
        $fill2 = min(max($percent - $segMax, 0), $segMax);
        $fill3 = min(max($percent - (2 * $segMax), 0), $segMax);

        $fill1Pct = $segMax > 0 ? ($fill1 / $segMax) * 100 : 0;
        $fill2Pct = $segMax > 0 ? ($fill2 / $segMax) * 100 : 0;
        $fill3Pct = $segMax > 0 ? ($fill3 / $segMax) * 100 : 0;
    ?>
    <a class="monthly-card-link" href="<?= h($cardUrl) ?>">
    <div class="card">
        <div class="card-header">
            <div class="month"><?= h($month) ?></div>
            <div class="count"><?= (int)$specCount ?> <span>specs</span></div>
        </div>

        <div class="power-bar" aria-label="Monthly specs progress">
            <div class="power-segment red">
                <div class="seg-fill" style="width: <?= round($fill1Pct, 2) ?>%;"></div>
            </div>
            <div class="power-segment yellow">
                <div class="seg-fill" style="width: <?= round($fill2Pct, 2) ?>%;"></div>
            </div>
            <div class="power-segment green">
                <div class="seg-fill" style="width: <?= round($fill3Pct, 2) ?>%;"></div>
            </div>
        </div>

        <div class="scale"><?= (int)$specCount ?> / <?= $max ?> (Peak)</div>
    </div>
    </a>
<?php endforeach; ?>
</div>

<script>
function filterSpecs() {
    document.getElementById('monthlySpecsFilterForm').submit();
}
</script>
