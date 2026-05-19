<?php
/**
 * Products Used multi-select with inline selected chips.
 *
 * Options:
 *   products - id => title list
 *   selectedIds - array of pre-selected product ids
 *   field - form field name (default products._ids)
 *   pickerId - optional unique id suffix
 */
$products = $products ?? [];
$selectedIds = $selectedIds ?? [];
$field = $field ?? 'products._ids';
$pickerId = $pickerId ?? 'products-used';
$selectedWrapId = $pickerId . '-selected';
$searchId = $pickerId . '-search';
$selectId = $pickerId . '-picker';
?>
<style>
.products-used-wrap {
    margin-bottom: 1rem;
}
.products-used-wrap > label {
    display: block;
    font-weight: 600;
    margin-bottom: 0.5rem;
}
.products-used-selected {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    align-content: flex-start;
    gap: 0.35rem 0.5rem;
    min-height: 42px;
    padding: 0.5rem 0.65rem;
    margin-bottom: 0.5rem;
    border: 1px solid #cfd8e3;
    border-radius: 8px;
    background: #f8fafc;
    line-height: 1.4;
}
.products-used-selected.is-empty {
    color: #6c757d;
    font-size: 0.875rem;
}
.products-used-tag {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    background: #e7f2ff;
    border: 1px solid #b9dafb;
    color: #19578f;
    border-radius: 999px;
    padding: 0.2rem 0.55rem 0.2rem 0.65rem;
    font-size: 0.8125rem;
    font-weight: 600;
    white-space: nowrap;
}
.products-used-tag__remove {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 1.1rem;
    height: 1.1rem;
    margin: 0;
    padding: 0;
    border: none;
    border-radius: 50%;
    background: transparent;
    color: #19578f;
    font-size: 1rem;
    line-height: 1;
    cursor: pointer;
    opacity: 0.75;
}
.products-used-tag__remove:hover {
    opacity: 1;
    background: rgba(25, 87, 143, 0.12);
}
.products-used-search {
    margin-bottom: 0.5rem;
    border-radius: 8px;
}
.products-used-picker {
    min-height: 140px !important;
    max-height: 200px;
    border: 1px solid #cfd8e3;
    border-radius: 8px;
    padding: 4px;
    background: #fff;
}
.products-used-picker option {
    padding: 6px 10px;
    border-radius: 4px;
    margin-bottom: 2px;
}
.products-used-picker option:checked {
    background: #fff linear-gradient(0deg, #fff 0%, #fff 100%);
    color: inherit;
}
.products-used-picker option[data-selected-hidden="1"] {
    display: none;
}
</style>

<div class="products-used-wrap" data-products-used-wrap="<?= h($pickerId); ?>">
    <label for="<?= h($searchId); ?>">Products Used</label>

    <div id="<?= h($selectedWrapId); ?>" class="products-used-selected is-empty" role="list" aria-live="polite">
        <span class="products-used-placeholder">No products selected — choose from the list below.</span>
    </div>

    <input type="text"
           id="<?= h($searchId); ?>"
           class="form-control products-used-search"
           placeholder="Search products to add..."
           autocomplete="off">

    <?php
    echo $this->Form->control($field, [
        'type' => 'select',
        'multiple' => true,
        'size' => 8,
        'options' => $products,
        'class' => 'form-control products-used-picker',
        'label' => false,
        'id' => $selectId,
        'value' => $selectedIds,
    ]);
    ?>
    <small class="text-muted d-block mt-1">Click a product to add it. Selected products appear above, inline.</small>
</div>

<script>
(function () {
    var wrap = document.querySelector('[data-products-used-wrap="<?= h($pickerId); ?>"]');
    if (!wrap) {
        return;
    }
    var searchInput = document.getElementById('<?= h($searchId); ?>');
    var select = document.getElementById('<?= h($selectId); ?>');
    var selectedWrap = document.getElementById('<?= h($selectedWrapId); ?>');
    if (!select || !selectedWrap) {
        return;
    }

    function escapeHtml(str) {
        var div = document.createElement('div');
        div.textContent = str;
        return div.innerHTML;
    }

    function syncOptionVisibility() {
        var term = (searchInput && searchInput.value ? searchInput.value : '').toLowerCase();
        Array.prototype.forEach.call(select.options, function (opt) {
            if (opt.selected) {
                opt.setAttribute('data-selected-hidden', '1');
                opt.style.display = 'none';
                return;
            }
            opt.removeAttribute('data-selected-hidden');
            var txt = (opt.text || '').toLowerCase();
            var match = !term || txt.indexOf(term) !== -1;
            opt.style.display = match ? '' : 'none';
        });
    }

    function renderSelectedTags() {
        var names = [];
        var html = '';
        Array.prototype.forEach.call(select.options, function (opt) {
            if (!opt.selected) {
                return;
            }
            names.push(opt.text || '');
            html += '<span class="products-used-tag" role="listitem">' +
                '<span class="products-used-tag__label">' + escapeHtml(opt.text || '') + '</span>' +
                '<button type="button" class="products-used-tag__remove" data-value="' + escapeHtml(opt.value) + '" title="Remove">&times;</button>' +
                '</span>';
        });

        if (html) {
            selectedWrap.innerHTML = html;
            selectedWrap.classList.remove('is-empty');
        } else {
            selectedWrap.innerHTML = '<span class="products-used-placeholder">No products selected — choose from the list below.</span>';
            selectedWrap.classList.add('is-empty');
        }

        syncOptionVisibility();
    }

    selectedWrap.addEventListener('click', function (e) {
        var btn = e.target.closest('.products-used-tag__remove');
        if (!btn) {
            return;
        }
        var val = btn.getAttribute('data-value');
        Array.prototype.forEach.call(select.options, function (opt) {
            if (opt.value === val) {
                opt.selected = false;
            }
        });
        renderSelectedTags();
    });

    select.addEventListener('mousedown', function (e) {
        if (e.target.tagName !== 'OPTION') {
            return;
        }
        e.preventDefault();
        var opt = e.target;
        if (!opt.selected) {
            opt.selected = true;
            renderSelectedTags();
        }
    });

    select.addEventListener('change', renderSelectedTags);

    if (searchInput) {
        searchInput.addEventListener('input', syncOptionVisibility);
    }

    renderSelectedTags();
})();
</script>
