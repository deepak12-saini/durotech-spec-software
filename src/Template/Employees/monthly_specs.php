<?php
$max = 20; // Peak value
?>

<style>
h2.page-title {
    font-weight: 600;
    margin-bottom: 20px;
    text-align: center;
    /* color: #1c1c1e; */
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
    margin-bottom: 16px;
    width: 60%;
    margin-left: auto;
    margin-right: auto;

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
    height: 12px;
    background: #eee;
    border-radius: 12px;
    display: flex;
    overflow: hidden;
    margin-top: 6px;
}

.power-segment {
    height: 100%;
}

/* Individual segments */
.power-segment {
    flex: 1; /* Equal width */
    transition: opacity 0.3s ease;
}

/* Inactive segment */
.power-segment.inactive {
    background: #ddd;
}

/* Active segments colors */
.power-segment.red { background: #ff3b30; }
.power-segment.yellow { background: #ffcc00; }
.power-segment.green { background: #34c759; }

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

.filter-dropdown select {
    padding: 6px 12px;
    border-radius: 8px;
    border: 1px solid #ccc;
    font-size: 14px;
    cursor: pointer;
}
</style>

<h2 class="page-title">
    Josh – Monthly Specs (<?= h($selectedYear) ?>)
</h2>

<div class="filter-dropdown">
    <select id="timeFilter" onchange="filterSpecs()">
        <option value="today" <?= $filter === 'today' ? 'selected' : '' ?>>Today</option>
        <option value="month" <?= $filter === 'month' ? 'selected' : '' ?>>This Month</option>
        <option value="year" <?= $filter === 'year' ? 'selected' : '' ?>>This Year</option>
    </select>
</div>

<?php foreach ($monthlySpecs as $month => $specCount): ?>
    <?php $percent = min(($specCount / $max) * 100, 100); ?>
    <?php
        // Determine number of active segments (0 to 3)
        $activeSegments = round($percent / 33.33);
        $colors = ['red', 'yellow', 'green'];
    ?>
    <div class="card">
        <div class="card-header">
            <div class="month"><?= h($month) ?></div>
            <div class="count"><?= (int)$specCount ?> <span>specs</span></div>
        </div>

        <!-- <div class="power-bar">
            <?php
            // $remainingPercent = ($specCount / $max) * 100; // 0 to 100
            // foreach ($colors as $color):
            //     $fill = min($remainingPercent, 33.33);
            //     $remainingPercent -= $fill;
            ?>
                <div class="power-segment <?= $color ?>" style="width: <?= $fill ?>%;"></div>
            <?php //endforeach; ?>
        </div> -->

        <div class="scale"><?= (int)$specCount ?> / <?= $max ?> (Peak)</div>
    </div>
<?php endforeach; ?>

<script>
function filterSpecs() {
    const filter = document.getElementById('timeFilter').value;
    window.location.href = "?filter=" + filter;
}
</script>
