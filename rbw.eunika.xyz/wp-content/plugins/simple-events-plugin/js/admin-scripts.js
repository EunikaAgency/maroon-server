jQuery(document).ready(function ($) {
    var suggestionsData = {};

    // Load the suggestions data from the JSON config
    $.getJSON(plugin_vars.suggestions_url, function (data) {
        suggestionsData = data;
    });

    // Function to append the selected suggestion to the input or textarea as a comma-separated value
    function appendSuggestionToField(fieldElement, selectedValue) {
        var currentValue = fieldElement.val().trim();

        // If there's already a value, append the new one with a comma
        if (currentValue.length > 0) {
            currentValue += ', ' + selectedValue;
        } else {
            currentValue = selectedValue; // Set the first value
        }

        fieldElement.val(currentValue); // Update the input field with the new value
    }

    // Initialize autosuggest for both input and textarea elements
    function initAutosuggest(fieldName) {
        var fieldElement = $('#' + fieldName);

        // On typing or focus, show suggestions
        fieldElement.on('input focus', function () {
            var suggestListId = '#suggest_' + fieldName.split('_')[1]; // Find the suggestion list
            var suggestBox = $(suggestListId);
            var inputValue = fieldElement.val().toLowerCase();

            // Get matching suggestions from the loaded data
            var matches = suggestionsData[fieldName];
            if (inputValue.length > 0) {
                matches = matches.filter(function (suggestion) {
                    return suggestion.toLowerCase().indexOf(inputValue) !== -1;
                });
            }

            suggestBox.empty(); // Clear the suggestion box

            // Append matching suggestions to the suggestion box
            matches.forEach(function (match) {
                suggestBox.append('<div class="suggest-item">' + match + '</div>');
            });

            // Handle clicking a suggestion
            suggestBox.off('click').on('click', '.suggest-item', function () {
                var selectedValue = $(this).text().trim();
                appendSuggestionToField(fieldElement, selectedValue); // Append the suggestion to the input/textarea
                suggestBox.empty(); // Clear the suggestion box
            });
        });
    }

    // Initialize autosuggest for all fields
    var autosuggestFields = [
        'event_organizer',
        'event_location',
        'event_type',
        'event_activities',
        'event_features',
        'event_health_safety',
        'event_ticket_inclusions',
        'event_terms_conditions'
    ];

    autosuggestFields.forEach(function (field) {
        initAutosuggest(field);
    });

    // Hide suggestion boxes when clicking outside of the suggest field or suggestion list
    $(document).on('click', function (e) {
        if (!$(e.target).closest('.autosuggest').length && !$(e.target).closest('.suggest-list').length) {
            $('.suggest-list').empty(); // Hide suggestions when clicking outside
        }
    });
});
