<script type="text/javascript">
(function () {
	if (window.__specCommentsUiBound) return;
	window.__specCommentsUiBound = true;

	window.renumberCommentRows = function () {
		$('#specCommentsList .commentdiv.spec-comment-row').each(function (i) {
			var n = i + 1;
			$(this).attr('id', 'commentdiv_' + n);
			$(this).find('.spec-comment-row__num').text(n);
			var $rm = $(this).find('.spec-comment-row__remove');
			if ($rm.length) {
				$rm.attr('onclick', 'commnetdivremove(' + n + ')');
			}
		});
		if (typeof window.syncCommentPresetChips === 'function') {
			window.syncCommentPresetChips();
		}
	};

	window.addmorecomment = function (presetValue) {
		var newdiv = $('#specCommentsList .commentdiv.spec-comment-row').length + 1;
		var val = (typeof presetValue === 'string') ? presetValue : '';
		var safeVal = $('<div/>').text(val).html();
		var html = ''
			+ '<div class="commentdiv spec-comment-row" id="commentdiv_' + newdiv + '">'
			+ '<span class="spec-comment-row__num">' + newdiv + '</span>'
			+ '<input type="text" class="spec-comment-input" name="comment[]" value="' + safeVal + '" placeholder="Type a custom comment, or click a preset above">'
			+ '<a href="javascript:void(0);" class="spec-comment-row__remove" onclick="commnetdivremove(' + newdiv + ')" title="Remove">×</a>'
			+ '</div>';
		$("#addcommentnew").append(html);
		if (typeof window.syncCommentPresetChips === 'function') {
			window.syncCommentPresetChips();
		}
	};

	window.commnetdivremove = function (newdiv) {
		$("#commentdiv_" + newdiv).remove();
		window.renumberCommentRows();
	};

	window.getExistingCommentTexts = function () {
		var texts = [];
		$('.commentdiv input[name="comment[]"]').each(function () {
			var t = (($(this).val() || '') + '').trim();
			if (t !== '') texts.push(t.toLowerCase());
		});
		return texts;
	};

	window.syncCommentPresetChips = function () {
		var existing = window.getExistingCommentTexts();
		$('#specCommentPresetList .spec-comment-chip').each(function () {
			var text = (($(this).attr('data-preset') || '') + '').trim().toLowerCase();
			var used = text !== '' && existing.indexOf(text) !== -1;
			$(this).toggleClass('is-used', used);
			$(this).find('i.fa').toggleClass('fa-check', used).toggleClass('fa-plus', !used);
			$(this).attr('title', used ? 'Already added' : 'Click to add this comment');
		});
	};

	window.appendCommentText = function (text) {
		text = (text || '').trim();
		if (!text) return false;
		var existing = window.getExistingCommentTexts();
		if (existing.indexOf(text.toLowerCase()) !== -1) {
			return false;
		}
		var filled = false;
		$('.commentdiv input[name="comment[]"]').each(function () {
			if (filled) return;
			if ((($(this).val() || '') + '').trim() === '') {
				$(this).val(text);
				filled = true;
			}
		});
		if (!filled) {
			window.addmorecomment(text);
		} else {
			window.syncCommentPresetChips();
		}
		return true;
	};

	$(document).on('click', '#specCommentPresetList .spec-comment-chip', function (e) {
		e.preventDefault();
		var $chip = $(this);
		if ($chip.hasClass('is-used')) {
			return;
		}
		var text = (($chip.attr('data-preset') || '') + '').trim();
		if (!text) return;
		if (!window.appendCommentText(text)) {
			window.syncCommentPresetChips();
		}
	});
	$(document).on('input change', '.commentdiv input[name="comment[]"]', function () {
		window.syncCommentPresetChips();
	});
	$(function () {
		window.syncCommentPresetChips();
	});
})();
</script>
