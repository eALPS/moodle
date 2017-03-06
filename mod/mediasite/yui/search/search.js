YUI.add('moodle-mod_mediasite-search', function (Y, NAME) {

    M.mod_mediasite = M.mod_mediasite || {};
    M.mod_mediasite.search = {
        site: -1,
        resourceId: '',
        resourceType: '',
        detailsNode: null,
        gateNode: null,
        nameNode: null,
        descriptionNode: null,
        searchNode: null,
        loading: null,
        form: null,
        eventHandlers: [],
        courseId: -1,
        submissionPoller: null,
        submissionComplete: false,
        submissionId: -1,
        pollRetryCount: 0,
        displayPopup: function (innerHtml) {
            var popupWindow = window.open("", "Popup Window", "width=200, height=100");
            popupWindow.document.write(innerHtml);
        },
        init: function (formid, courseid) {
            var self = this;
            self.courseId = courseid;
            self.form = Y.one('#' + formid);
            if (!self.form) {
                //console.log('The form identified by ' + formid + ' could not be found. Bailing.');
                return;
            }
            self.eventHandlers.push(
                self.form.on('submit', this.handleSubmission, this)
            );

            self.searchNode = Y.one('#id_search_results');
            if (!self.searchNode) {
                //console.log('The node identified by id_search_result could not be found. Bailing.');
                return;
            }
            self.loadingIcon = Y.Node.create('<img alt="loading" class="loading-icon" src="' + M.util.image_url('i/loading', 'moodle') + '"/img>');

            skipClientValidation = false;

            Y.on("click", function () {
                var caldiv = Y.one("#id_untildatecalendar");
                if (caldiv.getHTML()) {
                    // It is expanded
                    caldiv.setContent('');
                } else {
                    var cal = new Y.Calendar({
                        width: 300,
                        date: new Date()
                    }).render('#id_untildatecalendar');
                    cal.after('selectionChange', function (ev) {
                        var date = ev.newSelection[0];
                        // %F is %Y-%m-%d (ISO 8601 date format)
                        date = Y.DataType.Date.format(date, {format: '%F'});
                        Y.one('#id_untildate').set('value', date);
                        caldiv.setContent('');
                    });
                }
            }, "#id_untilcalendar", self);
            Y.on("click", function () {
                var caldiv = Y.one("#id_afterdatecalendar");
                if (caldiv.getHTML()) {
                    // It is expanded
                    caldiv.setContent('');
                } else {
                    var cal = new Y.Calendar({
                        width: 300,
                        date: new Date()
                    }).render('#id_afterdatecalendar');
                    cal.after('selectionChange', function (ev) {
                        var date = ev.newSelection[0];
                        // %F is %Y-%m-%d (ISO 8601 date format)
                        date = Y.DataType.Date.format(date, {format: '%F'});
                        Y.one('#id_afterdate').set('value', date);
                        caldiv.setContent('');
                    });
                }
            }, "#id_aftercalendar", self);
            // This gets call because of the PHP line: $table->id = 'id_resource_table';
            Y.delegate("click", function (e) {
                var self = this;
                e.preventDefault();
                var iconPath = null;
                var detailsContainer = null;
                var collapsedStart = -1;
                var resourceUrl = '';
                var name = '';
                if (e.target.getAttribute('class') === 'selectresource') {
                    self.site = e.target.getAttribute('site');
                    self.resourceId = e.target.getAttribute('resource');
                    self.resourceType = e.target.getAttribute('type');
                    self.nameNode = opener.document.getElementById('id_name');
                    self.nameNode.disabled = false;
                    self.nameNode.value = e.target.getAttribute('name');
                    opener.document.getElementById('id_resourceid').value = self.resourceId;
                    opener.document.getElementById('id_resourcetype').value = self.resourceType;
                    opener.document.getElementById('id_siteid').value = self.site;
                    self.descriptionNode = opener.document.getElementById('id_description');

                    var decriptionConfig = {
                        method: 'GET',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        data: {
                            site: self.site,
                            resource: self.resourceId,
                            type: self.resourceType
                        },
                        on: {
                            success: self.descriptionSuccess,
                            failure: self.descriptionFailure
                        },
                        context: self
                    };
                    if (self.resourceType == M.util.get_string('presentation', 'mediasite')) {
                        resourceUrl = M.cfg.wwwroot + '/mod/mediasite/singlepresentation.php';
                    } else {
                        resourceUrl = M.cfg.wwwroot + '/mod/mediasite/singlecatalog.php';
                    }
                    Y.io(resourceUrl, decriptionConfig);
                }
                else if (e.target.getAttribute('class') === 'expandresource') {
                    self.site = e.target.getAttribute('site');
                    self.resourceId = e.target.getAttribute('resource');
                    self.resourceType = e.target.getAttribute('type');
                    iconPath = e.target.getAttribute('src');
                    collapsedStart = iconPath.search(/t\/collapsed$/g);

                    detailsContainer = e.target.ancestor();
                    //var detailsContainer = this.ancestor().next().next();
                    self.detailsNode = detailsContainer.one('.sofo-details');

                    //var previewContainer = this.ancestor().next().next().next();
                    //var previewNode = previewContainer.one('div').one('iframe');
                    //previewNode.setStyle('display', 'none');
                    //previewContainer.setStyle('display', 'none');

                    if (collapsedStart > -1) {
                        if (self.detailsNode.getHTML() === '') {
                            var expandConfig = {
                                method: 'GET',
                                headers: {
                                    'Content-Type': 'application/json'
                                },
                                data: {
                                    site: self.site,
                                    resource: self.resourceId,
                                    type: self.resourceType
                                },
                                on: {
                                    success: self.expandSuccess,
                                    failure: self.expandFailure
                                },
                                context: self
                            };
                            if (self.resourceType == M.util.get_string('presentation', 'mediasite')) {
                                resourceUrl = M.cfg.wwwroot + '/mod/mediasite/expandpresentation.php';
                            } else {
                                resourceUrl = M.cfg.wwwroot + '/mod/mediasite/expandcatalog.php';
                            }
                            Y.io(resourceUrl, expandConfig);
                        } else {
                            self.detailsNode.show(true);
                        }
                        e.target.setAttribute('src', iconPath.replace(/t\/collapsed/g, 't/expanded'));
                    } else {
                        self.detailsNode.hide(true);
                        e.target.setAttribute('src', iconPath.replace(/t\/expanded/g, 't/collapsed'));
                    }
                }
            }, "#id_search_results, #demo .results", "img", self);
            Y.on('change', function (e) {
                var self = this;
                self.searchNode.setHTML('');
                e.preventDefault();
                e.stopPropagation();
                var siteTypeConfig = {
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    data: {
                        siteid: Y.one('#id_siteid').get('value')
                    },
                    on: {
                        success: function (id, o) {
                            var afterselect = Y.one('#id_searchafterselect');
                            var after = Y.one('#id_afterdate');
                            var untilselect = Y.one('#id_searchuntilselect');
                            var until = Y.one('#id_untildate');
                            var presenter = Y.one('#id_presentersearch');
                            if (o.responseText == 'soap') {
                                // Uncheck the dates and disable them if the site is SOAP
                                afterselect.set('checked', false);
                                afterselect.set('disabled', true);
                                after.set('value', '');
                                untilselect.set('checked', false);
                                untilselect.set('disabled', true);
                                until.set('value', '');
                                presenter.set('checked', false);
                                presenter.set('disabled', true);
                            } else if (o.responseText == 'odata') {
                                afterselect.set('checked', false);
                                afterselect.set('disabled', false);
                                untilselect.set('checked', false);
                                untilselect.set('disabled', false);
                                presenter.set('checked', true);
                                presenter.set('disabled', false);
                            }
                        }
                    },
                    context: self
                };
                var siteTypeUrl = M.cfg.wwwroot + '/mod/mediasite/sitetype.php';
                Y.io(siteTypeUrl, siteTypeConfig);
            }, '#id_siteid', self);
            Y.on('change', function (e) {
                var self = this;
                //console.log('Resource type change');
                self.searchNode.setHTML('');
                e.preventDefault();
                e.stopPropagation();
            }, '#id_resourcetype', self);
            Y.on('change', function (e) {
                // Clear the results when changed
                var self = this;
                //console.log('Advanced type change');
                self.searchNode.setHTML('');
                // Validation
                e.preventDefault();
                e.stopPropagation();
            }, '#id_namesearch, #id_descriptionsearch, #id_tagsearch, #id_presentersearch, #id_searchafterselect, #id_searchutilselect', self);
            Y.on('keypress', function (e) {
                var self = this;
                self.searchNode.setHTML('');
            }, '#id_searchtext', self);
            Y.on('unload', function (e) {
                //alert('Unload');
            }, this);

        },
        searchSuccess: function (id, o) {
            var self = this;
            //self.searchNode.setHTML(o.responseText);
            var resultsNode = Y.Node.create(o.responseText);
            self.searchNode.replaceChild(resultsNode, self.loadingIcon);
            self.searchNode.setStyle('opacity', 1.0);
            document.body.style.cursor = 'default';
            self.submissionComplete = true;
            self.submissionId = -1;
        },
        searchFailure: function (id, o) {
            var self = this;
            self.searchNode.set('text', 'Failed ' + o.responseText);
            document.body.style.cursor = 'default';
            self.submissionComplete = true;
            self.submissionId = -1;
        },
        checkDate: function (m, d, y) {
            // From: http://phpjs.org/functions
            // +   original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
            // +   improved by: Pyerre
            // +   improved by: Theriault
            // *     example 1: checkdate(12, 31, 2000);
            // *     returns 1: true
            // *     example 2: checkdate(2, 29, 2001);
            // *     returns 2: false
            // *     example 3: checkdate(3, 31, 2008);
            // *     returns 3: true
            // *     example 4: checkdate(1, 390, 2000);
            // *     returns 4: false
            return m > 0 && m < 13 && y > 0 && y < 32768 && d > 0 && d <= (new Date(y, m, 0)).getDate();
        },
        handleSubmission: function (e) {
            function Random(seed) {
                this.m_w = seed;
                this.m_z = 987654321;
                this.mask = 0xffffffff;
                // Returns number between 0 (inclusive) and 1.0 (exclusive),
                // just like Math.random().
                Random.prototype.random = function () {
                    this.m_z = (36969 * (this.m_z & 65535) + (this.m_z >> 16)) & this.mask;
                    this.m_w = (18000 * (this.m_w & 65535) + (this.m_w >> 16)) & this.mask;
                    var result = ((this.m_z << 16) + this.m_w) & this.mask;
                    result /= 4294967296;
                    return result + 0.5;
                }
            }
            var self = this;
            e.preventDefault();
            e.stopPropagation();
            if (!skipClientValidation) {
                var errorNodes = e.target.all('.sofo-validation-notice');
                errorNodes.empty();
                var namecheck = e.target.one('input[id=id_namesearch]').get('checked');
                var descriptioncheck = e.target.one('input[id=id_descriptionsearch]').get('checked');
                var tagcheck = e.target.one('input[id=id_tagsearch]').get('checked');
                var presentercheck = e.target.one('input[id=id_presentersearch]').get('checked');
                var afterselect = e.target.one('input[id=id_searchafterselect]').get('checked');
                var afternode = e.target.one('input[name=afterdate]');
                var after = afterselect ? afternode.get('value') : 'na';
                var untilselect = e.target.one('input[id=id_searchuntilselect]').get('checked');
                var untilnode = e.target.one('input[name=untildate]');
                var until = untilselect ? untilnode.get('value') : 'na';
                var searchText = e.target.one('input[name=searchtext]').get('value');
                var siteid = e.target.one('#id_siteid').get('value');
                var dre = /((?:19|20)[0-9]{2})[- \/.](0[1-9]|1[012])[- \/.](0[1-9]|[12][0-9]|3[01])|$/g;
                var res;
                var notice;
                var enteredAfterDate;
                var enteredUntilDate;
                var currentDate = new Date();
                if(searchText && !/^\s*$/.test(searchText)) {
                    // Non-empty searchText means that at least one
                    // of the fields need to be selected to search
                    if(!namecheck &&
                       !descriptioncheck &&
                       !tagcheck &&
                       !presentercheck) {
                        notice = Y.Node.create('<div class="sofo-validation-notice">' + M.util.get_string('onefieldselect', 'mediasite') + '</div>');
                        e.target.insertBefore(notice, e.target.one('input[id=id_namesearch]'));
                        return;
                    }
                } else {
                    // Check for non-default advanced state
                    if(!namecheck ||
                       !descriptioncheck ||
                       !tagcheck ||
                       !presentercheck ||
                        afterselect ||
                        untilselect) {
                        notice = Y.Node.create('<div class="sofo-validation-notice">' + M.util.get_string('advancedskipped', 'mediasite') + '</div>');
                        e.target.insertBefore(notice, e.target.one('input[id=id_namesearch]'));
                        afterselect = false;
                        untilselect = false;
                    }
                }
                if (afterselect) {
                    dre.lastIndex = 0;
                    res = dre.exec(after);
                    if (res.length == 4) {
                        if (this.checkDate(res[2], res[3], res[1])) {
                            enteredAfterDate = new Date(after);
                            if (enteredAfterDate < currentDate) {
                                //console.log(after + ' is a date');
                            } else {
                                notice = Y.Node.create('<div class="sofo-validation-notice">' + M.util.get_string('futuredate', 'mediasite', after) + '</div>');
                                afternode.ancestor().insert(notice, afternode);
                            }
                        } else {
                            notice = Y.Node.create('<div class="sofo-validation-notice">' + M.util.get_string('notadate', 'mediasite', after) + '</div>');
                            afternode.ancestor().insert(notice, afternode);
                            return;
                        }
                    } else {
                        notice = Y.Node.create('<div class="sofo-validation-notice">' + M.util.get_string('notadate', 'mediasite', after) + '</div>');
                        afternode.ancestor().insert(notice, afternode);
                        return;
                    }
                }
                if (untilselect) {
                    dre.lastIndex = 0;
                    res = dre.exec(until);
                    if (res.length == 4) {
                        if (this.checkDate(res[2], res[3], res[1])) {
                            enteredUntilDate = new Date(until);
                            if (enteredUntilDate < currentDate) {
                                if (afterselect) {
                                    if (enteredUntilDate < enteredAfterDate) {
                                        notice = Y.Node.create('<div class="sofo-validation-notice">' + M.util.get_string('impossibledatecombination', 'mediasite') + '</div>');
                                        untilnode.ancestor().insert(notice, afternode);
                                        return;
                                    }
                                }
                            } else {
                                notice = Y.Node.create('<div class="sofo-validation-notice">' + M.util.get_string('futuredate', 'mediasite', until) + '</div>');
                                untilnode.ancestor().insert(notice, afternode);
                                return;
                            }
                            //console.log(until + ' is a date');
                        } else {
                            notice = Y.Node.create('<div class="sofo-validation-notice">' + M.util.get_string('notadate', 'mediasite', until) + '</div>');
                            untilnode.ancestor().insert(notice, untilnode);
                            return;
                        }
                    } else {
                        notice = Y.Node.create('<div class="sofo-validation-notice">' + M.util.get_string('notadate', 'mediasite', until) + '</div>');
                        untilnode.ancestor().insert(notice, untilnode);
                        return;
                    }
                }
                self.resourceType = e.target.one('#id_resourcetype').get('value');
                self.submissionComplete = false;
                self.pollRetryCount = 0;
// ---------------------------------------------------------
                // The waiting cursor
                //document.body.style.cursor = 'wait';
// ---------------------------------------------------------
                var rnd = new Random((new Date()).getTime())
                self.submissionId = Math.floor(rnd.random() * 1000000000001);
                var searchUrl = M.cfg.wwwroot + '/mod/mediasite/mediasitesearch.php';
                self.searchNode = Y.one('#id_search_results').setStyle('opacity', 0.5);
                self.searchNode.empty();
// ---------------------------------------------------------
                // The loading icon
                    self.searchNode.appendChild(self.loadingIcon);
                    // We need to store some value to query on...
                    var searchConfig = {
                        method: 'GET',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        data: {
                            sid: self.submissionId,
                            course: self.courseId,
                            site: siteid,
                            search: searchText,
                            type: this.resourceType,
                            name: namecheck,
                            description: descriptioncheck,
                            tag: tagcheck,
                            presenter: presentercheck,
                            afterselect: afterselect,
                            after: after,
                            untilselect: untilselect,
                            until: until
                        },
                        on: {
                            success: self.searchSuccess,
                            failure: self.searchFailure
                        },
                        context: self
                    };
                    // This enables 'normal search'
                    Y.io(searchUrl, searchConfig);
                } else {
                    //console.log('Cancel');
                    var cancelButton = opener.document.getElementById('id_cancel');
                    cancelButton.click();
                    window.close();
                }
        },
        descriptionSuccess: function (id, o) {
            var self = this;
            var response = Y.JSON.parse(o.responseText);
            self.descriptionNode.disabled = false;
            if(!response.Description || /^\s*$/.test(response.Description)) {
                self.descriptionNode.value = '';
            } else {
                self.descriptionNode.value = response.Description ;
            }
            window.close();
        },
        descriptionFailure: function (id, o) {
            var self = this;
            self.descriptionNode.value = o.responseText;
            self.nameNode.disabled = true;
        },
        dateFormat: function (date, format) {
            // Calculate date parts and replace instances in format string accordingly
            format = format.replace("DD", (date.getDate() < 10 ? '0' : '') + date.getDate()); // Pad with '0' if needed
            format = format.replace("MM", (date.getMonth() < 9 ? '0' : '') + (date.getMonth() + 1)); // Months are zero-based
            format = format.replace("YYYY", date.getFullYear());
            return format;
        },
        expandSuccess: function (id, o) {
            var self = this;
            self.detailsNode.setHTML('Working....');
            //self.detailsNode.setHTML(o.responseText);
//            try {
                var response = Y.JSON.parse(o.responseText);
//            } catch (error) {
//                self.detailsNode.setHTML(error.name + '<br/>Exception<br/>' + error.message);
//                self.displayPopup(o.responseText);
//                return;
//            }
            var table = '';
            if (self.resourceType == M.util.get_string('presentation', 'mediasite')) {
                if (response.Thumbnails && response.Thumbnails.length > 0) {
                    table += '<img class="sofo-thumbnail" onerror="this.style.display=\'none\'" onload="this.style.display=\'block\'" src="thumbnail.php?site=' + M.mod_mediasite.search.site + '&resource=' + M.mod_mediasite.search.resourceId + '&duration=' + 300 + '&restrictip=' + 0 + '&url=' + response.Thumbnails[0].ThumbnailUrl + '" /img>';
                }
                table += '<br/>';
                if(response.Presentation.RecordDate) {
                    var dateParse = /^\s*(\d{4})-(\d\d)-(\d\d)/m;
                    var dateParts = dateParse.exec(response.Presentation.RecordDate);
                    if(dateParts) {
                        table += '<span class="sofo-air-date">';
                        var d = new Date(dateParts[1], dateParts[2] - 1, dateParts[3]);
                        table += this.dateFormat(d, 'MM/DD/YYYY');
                        table += '</span>';
                    }
                }
                if (response.Presenters && response.Presenters.length > 1) {
                    table += '<span class="sofo-presenter">';
                    table += '<ul class="sofo-presenter-list">';
                    for (var i = 0; i < response.Presenters.length; i++) {
                        table += '<li>' + (response.Presenters[i].DisplayName ? response.Presenters[i].DisplayName + ' ' : '') + '</li>';
                    }
                    table += '</ul>';
                    table += '</span>';
                } else if (response.Presenters.length === 1) {
                    table += '<span class="sofo-presenter">';

                    table += (response.Presenters[0].DisplayName ? response.Presenters[0].DisplayName + ' ' : '');

                    table += '</span>';
                }
                if (response.Presentation.Description) {
                    table += '<div class="sofo-description">';
                    table += response.Presentation.Description;
                    table += '</div>';
                }
                table += '<br/>';
            } else {
                if (response.Description) {
                    table += '<div class="sofo-description">';
                    table += response.Description;
                    table += '</div>';
                }
                table += '<br/>';
            }
            self.detailsNode.setHTML(table);
        },
        expandFailure: function (id, o) {
            var self = this;
            self.detailsNode.setHTML('Expand Failed ' + o.responseText);
        }
    };

}, '@VERSION@', {
    "requires": [
        "base",
        "calendar",
        "event",
        "event-delegate",
        "io-base",
        "io-form",
        "json",
        "model",
        "node",
        "node-event-delegate",
        "node-base",
        "view"
    ]
});
