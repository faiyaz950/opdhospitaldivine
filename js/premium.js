(function () {
    'use strict';

    var parentPage = {
        'add-patient.php': 'show_patients.php',
        'edit-patient.php': 'show_patients.php',
        'add-opd.php': 'show_patients.php',
        'add-investigate.php': 'show_patients.php',
        'add-out-investigate.php': 'show_patients.php',
        'add-ipd1.php': 'show_patients.php',
        'add-report.php': 'show_reports.php',
        'edit-reporttype.php': 'show_reports.php',
        'add-ipd.php': 'show_ipd.php',
        'edit-ipdtype.php': 'show_ipd.php',
        'add-outinv-report.php': 'show_outinv_reports.php',
        'edit-outinvreporttype.php': 'show_outinv_reports.php',
        'add-admin.php': 'show_admin.php',
        'edit_admin.php': 'show_admin.php',
        'add-doctor.php': 'show_doctors.php',
        'add-appointment.php': 'show_appointment.php',
        'opd-report1.php': 'opd-report.php',
        'investigation-report1.php': 'investigation-report.php',
        'ipd-report1.php': 'ipd-report.php',
        'outinv-report1.php': 'outinv-report.php',
        'expense-report1.php': 'expense-report.php',
        'income-report1.php': 'income-report.php',
        'add-expense.php': 'show_expenses.php',
        'add-expense-type.php': 'show_exptype.php',
        'add-incomes.php': 'show_incomes.php',
        'add-income-type.php': 'show_incometype.php'
    };

    function each(selector, fn) {
        Array.prototype.forEach.call(document.querySelectorAll(selector), fn);
    }

    function isBlank(el) {
        return !el.textContent.replace(/\u00a0/g, ' ').trim() &&
            !el.querySelector('input, select, textarea, a, img, table');
    }

    function highlightNavigation() {
        var page = window.location.pathname.split('/').pop() || 'index.php';
        var target = parentPage[page] || page;

        each('.side-nav > li > a[href]', function (link) {
            var href = link.getAttribute('href');
            if (href === page || href === target) {
                link.parentNode.classList.add('hms-active');
            }
        });

        each('#cssmenu ul ul a[href]', function (link) {
            var href = link.getAttribute('href');
            if (href !== page && href !== target) {
                return;
            }
            link.parentNode.classList.add('hms-current');
            var top = link.closest('#cssmenu > ul > li');
            if (top) {
                top.classList.add('hms-current');
            }
        });
    }

    function textOf(el) {
        return el.textContent.replace(/\u00a0/g, ' ').replace(/\s+/g, ' ').trim();
    }

    function cellKind(td) {
        if (td.querySelector('img')) {
            return 'status';
        }
        var text = textOf(td);
        var links = td.querySelectorAll('a');
        if (!links.length) {
            return text ? 'data' : 'empty';
        }
        var linkText = '';
        Array.prototype.forEach.call(links, function (a) {
            linkText += a.textContent;
        });
        return text.replace(/\s/g, '') === linkText.replace(/\u00a0/g, '').replace(/\s/g, '') ? 'action' : 'data';
    }

    function compactTable(table) {
        var rows = Array.prototype.slice.call(table.rows);
        if (rows.length < 2 || !rows[0].cells.length || rows[0].cells[0].tagName !== 'TH') {
            return;
        }
        var head = rows[0];
        var body = rows.slice(1);
        var count = head.cells.length;
        var uniform = body.every(function (row) {
            return row.cells.length === count;
        });
        if (!uniform) {
            return;
        }

        var kinds = [];
        for (var c = 0; c < count; c++) {
            var seen = {};
            body.forEach(function (row) {
                seen[cellKind(row.cells[c])] = true;
            });
            kinds.push(seen);
        }

        var actionCols = [];
        kinds.forEach(function (seen, index) {
            if (seen.action && !seen.data && !seen.status) {
                actionCols.push(index);
            }
        });

        var longCols = [];
        for (var i = 0; i < count; i++) {
            var longest = 0;
            body.forEach(function (row) {
                longest = Math.max(longest, textOf(row.cells[i]).length);
            });
            if (longest > 20 && actionCols.indexOf(i) === -1) {
                longCols.push(i);
            }
        }

        var mergeTime = [];
        for (var d = 0; d < count - 1; d++) {
            if (/date/i.test(textOf(head.cells[d])) && /time/i.test(textOf(head.cells[d + 1])) &&
                actionCols.indexOf(d + 1) === -1) {
                mergeTime.push(d);
            }
        }

        rows.forEach(function (row) {
            var cells = Array.prototype.slice.call(row.cells);
            var isHead = row === head;
            var remove = [];

            longCols.forEach(function (index) {
                if (!isHead) {
                    cells[index].classList.add('hms-wrap');
                }
            });

            mergeTime.forEach(function (index) {
                var dateCell = cells[index];
                var timeCell = cells[index + 1];
                var sub = document.createElement('span');
                sub.className = 'hms-sub';
                while (timeCell.firstChild) {
                    sub.appendChild(timeCell.firstChild);
                }
                dateCell.appendChild(sub);
                dateCell.classList.add('hms-stack');
                remove.push(timeCell);
            });

            if (actionCols.length > 1 || (actionCols.length === 1 && !isHead)) {
                var holder = cells[actionCols[actionCols.length - 1]];
                if (isHead) {
                    holder.textContent = 'Actions';
                } else {
                    var box = document.createElement('div');
                    box.className = 'hms-actions';
                    actionCols.forEach(function (index) {
                        Array.prototype.slice.call(cells[index].querySelectorAll('a')).forEach(function (a) {
                            box.appendChild(a);
                        });
                    });
                    holder.textContent = '';
                    holder.appendChild(box);
                    if (box.children.length > 2) {
                        box.classList.add('is-many');
                    }
                }
                holder.classList.add('hms-actions-cell');
                actionCols.slice(0, -1).forEach(function (index) {
                    remove.push(cells[index]);
                });
            }

            remove.forEach(function (cell) {
                cell.parentNode.removeChild(cell);
            });
        });
    }

    function fitTables() {
        each('#page-wrapper .hms-table-card', function (card) {
            var table = card.querySelector('table');
            table.classList.remove('hms-tight');
            if (table.scrollWidth > card.clientWidth + 1) {
                table.classList.add('hms-tight');
            }
        });
    }

    function wrapTables() {
        each('#page-wrapper table.rowstyle-alt', function (table) {
            if (table.parentNode.classList.contains('hms-table-card')) {
                return;
            }
            var card = document.createElement('div');
            card.className = 'hms-table-card';
            table.parentNode.insertBefore(card, table);
            card.appendChild(table);
        });
    }

    function hideEmptyBlocks() {
        each('#page-wrapper .breadcrumb, #page-wrapper .records.round, #page-wrapper .page-header small', function (el) {
            if (isBlank(el)) {
                el.style.display = 'none';
            }
        });
    }

    var SEEN_DELAY = 3;

    function delaySeen(event) {
        var link = event.target.closest && event.target.closest('a[href*="-seen"]');
        if (!link || !/(opd|investigate|ipd)-seen\d*\.php\?/.test(link.getAttribute('href'))) {
            return;
        }
        event.preventDefault();
        if (link.hmsSeenDone) {
            return;
        }

        if (link.hmsSeenTimer) {
            clearInterval(link.hmsSeenTimer);
            link.hmsSeenTimer = null;
            link.classList.remove('hms-seen-pending');
            link.removeChild(link.querySelector('.hms-seen-count'));
            link.title = '';
            return;
        }

        var left = SEEN_DELAY;
        var count = document.createElement('span');
        count.className = 'hms-seen-count';
        count.textContent = left;
        link.appendChild(count);
        link.classList.add('hms-seen-pending');
        link.title = 'Click again to cancel';
        link.hmsSeenTimer = setInterval(function () {
            left -= 1;
            if (left > 0) {
                count.textContent = left;
                return;
            }
            clearInterval(link.hmsSeenTimer);
            link.hmsSeenDone = true;
            count.textContent = '…';
            markSeen(link);
        }, 1000);
    }

    // Sent in the background so several dots can count down and update at once.
    function markSeen(link) {
        if (!window.fetch) {
            window.location.href = link.href;
            return;
        }
        fetch(link.href, { credentials: 'same-origin' }).then(function (res) {
            if (!res.ok || /\/index\.php$/.test(res.url)) {
                throw new Error('not saved');
            }
            var tick = document.createElement('img');
            tick.src = 'images/Green_tick.png';
            link.parentNode.replaceChild(tick, link);
        }).catch(function () {
            window.location.href = link.href;
        });
    }

    document.addEventListener('click', delaySeen);

    document.addEventListener('DOMContentLoaded', function () {
        highlightNavigation();
        each('#page-wrapper table.rowstyle-alt', compactTable);
        wrapTables();
        hideEmptyBlocks();
        fitTables();
        if (document.fonts && document.fonts.ready) {
            document.fonts.ready.then(fitTables);
        }

        var resizeTimer;
        window.addEventListener('resize', function () {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(fitTables, 150);
        });
    });
})();
