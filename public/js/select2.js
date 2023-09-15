$(() => {

    $('.select2-general').select2({
        placeholder: '-Select an option-',
        allowClear: true
    });

    $('.particular-select2').select2({
        placeholder: '-Select Particular/s-',
        theme: 'classic',
        allowClear: true
    });

    $('.student-select2').select2({
        placeholder: '-Select Student/s-',
        // maximumSelectionLength: 1,
        allowClear: true
    });

    $('.prerequisite-select2').select2({
        placeholder: '-Select an option-',
        allowClear: true
    });

    $('.academic-year-dropdown, .academic-term-dropdown, .program-dropdown, .course-dropdown, .student-group-dropdown, .fee-category-dropdown').select2({
        placeholder: '-Select an option-',
        allowClear: true
    });

    $('.education-levels-select2').select2({
        placeholder: '-Select an option-',
        allowClear: true
    });

    $('.select2-program').select2({
        placeholder: '-Select an option-',
        allowClear: true
    });

    $('.select2-student-group').select2({
        placeholder: '-Select an option-',
        allowClear: true
    });

    $('.select2-fee-structure').select2({
        placeholder: '-Select an option-',
        allowClear: true
    });

    $('.select2-region, .select2-province, .select2-municipality, .select2-barangay').select2({
        placeholder: '-Select an option-',
        allowClear: true
    });

    $('.select2-guardian').select2({
        placeholder: '-Select Existing Guardian-',
        theme: 'classic',
        allowClear: true
    });

});
