$(document).ready(function () {
    $(".vi-slideaccord").accordion({
        active: false,
        heightStyle: 'content',
        collapsible: true,
    });
    $("table").tablesorter({dateFormat: "uk"});
    $("#srchTbl").keyup(function () {
        $("#idsearch").val("");
        var _searchStr = $(this).val().toLowerCase();

        $("table tbody tr").each(function () {
            if ($(this).text().toLowerCase().indexOf(_searchStr) == -1) {
                $(this).hide();
            }
            else {
                $(this).show();
            }
        });

    });
    $(".srchTbl").keyup(function () { 
        $("#idsearch").val("");
        var _searchStr = $(this).val().toLowerCase();

        $("table tbody tr").each(function () {
            if ($(this).text().toLowerCase().indexOf(_searchStr) == -1) {
                $(this).hide();
            }
            else {
                $(this).show();
            }
        });

    });
    $("#idsearch").keyup(function () {
        $("#srchTbl").val("");
        var _searchStr = $(this).val().toLowerCase();

        $("table tbody tr").each(function () {
            if ($(this).find("td:nth-child(2)").text().toLowerCase().indexOf(_searchStr) == -1) {
                $(this).hide();
            }
            else {
                $(this).show();
            }
        });

    }); 
      $("#idsearch2").keyup(function () {
        $("#srchTbl").val("");
        var _searchStr = $(this).val().toLowerCase();

        $("table tbody tr").each(function () {
            if ($(this).find("td:nth-child(3)").text().toLowerCase().indexOf(_searchStr) == -1) {
                $(this).hide();
            }
            else {
                $(this).show();
            }
        });

    });
});