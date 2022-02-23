"use strict";

// Class definition
var KTLayoutSearch = function () {
    // Private variables
    var element;
    var formElement;
    var mainElement;
    var resultsElement;
    var wrapperElement;
    var emptyElement;

    var preferencesElement;
    var preferencesShowElement;
    var preferencesDismissElement;

    var advancedOptionsFormElement;
    var advancedOptionsFormShowElement;
    var advancedOptionsFormCancelElement;
    var advancedOptionsFormSearchElement;

    var searchObject;

    // Private functions
    var process = function (search) {
        search.complete();
        axios.get('/api/search', {
            params: {
                query: search.getQuery()
            }
        }).then(function (res) {
            console.log(res);
            search.complete();
        });
    }

    var clear = function (search) {
        // Show recently viewed
        mainElement.classList.remove('d-none');
        // Hide results
        resultsElement.innerHTML = '';
        resultsElement.classList.add('d-none');
        // Hide empty message
        emptyElement.classList.add('d-none');
    }

    var createSearchItem = function (item) {
        var a = document.createElement('a');
        var container = document.createElement('div');
        var title = document.createElement('span');
        a.classList.add('d-flex', 'text-dark', 'text-hover-primary', 'align-items-center', 'mb-5')
        container.classList.add('d-flex', 'flex-column');
        title.classList.add('fs-6', 'fw-bold');
        container.appendChild(title);
        a.appendChild(container);
        title.textContent = item.name;
        return a;
    }

    // Public methods
    return {
        init: function () {
            // Elements
            element = document.querySelector('#kt_header_search');

            if (!element) {
                return;
            }

            wrapperElement = element.querySelector('[data-kt-search-element="wrapper"]');
            formElement = element.querySelector('[data-kt-search-element="form"]');
            mainElement = element.querySelector('[data-kt-search-element="main"]');
            resultsElement = element.querySelector('[data-kt-search-element="results"]');
            emptyElement = element.querySelector('[data-kt-search-element="empty"]');

            preferencesElement = element.querySelector('[data-kt-search-element="preferences"]');
            preferencesShowElement = element.querySelector('[data-kt-search-element="preferences-show"]');
            preferencesDismissElement = element.querySelector('[data-kt-search-element="preferences-dismiss"]');

            advancedOptionsFormElement = element.querySelector('[data-kt-search-element="advanced-options-form"]');
            advancedOptionsFormShowElement = element.querySelector('[data-kt-search-element="advanced-options-form-show"]');
            advancedOptionsFormCancelElement = element.querySelector('[data-kt-search-element="advanced-options-form-cancel"]');
            advancedOptionsFormSearchElement = element.querySelector('[data-kt-search-element="advanced-options-form-search"]');

            // Initialize search handler
            searchObject = new KTSearch(element);

            // Search handler
            searchObject.on('kt.search.process', function (search) {
                clear();
                axios.get('/site_search', {
                        params: {
                            query: search.getQuery()
                        }
                    })
                    .then(function (res) {
                        if (!!Object.keys(res.data).length) {
                            var container = document.createElement('div');
                            container.classList.add('scroll-y', 'mh-200px', 'mh-lg-350px');
                            Object.keys(res.data).forEach(function (key) {
                                var title = document.createElement('h3');
                                title.classList.add('fs-5', 'text-muted', 'm-0', 'pb-5');
                                title.textContent = key;
                                container.appendChild(title);
                                res.data[key].forEach(function (item) {
                                    container.appendChild(createSearchItem(item));
                                });
                            });

                            resultsElement.appendChild(container);
                            resultsElement.classList.remove('d-none');

                        } else {
                            emptyElement.classList.remove('d-none');

                        }
                        search.complete()
                    });
            });

            // Clear handler
            searchObject.on('kt.search.clear', clear);
        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTLayoutSearch.init();
});
