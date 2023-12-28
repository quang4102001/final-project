$(document).ready(function () {
    const checkAllChange = function () {
        var isChecked = $("#checkAll").prop("checked");

        $(".checkBox").prop("checked", isChecked);
    };

    // Khi click vào checkbox ở header
    $("#checkAll").change(function () {
        checkAllChange();
    });

    // Khi click vào th hoặc td, thay đổi trạng thái của checkbox
    $("td").click(function (e) {
        if (e.target.type !== "checkbox") {
            var checkbox = $(this).find(".checkBox");

            checkbox.prop("checked", !checkbox.prop("checked"));
            const allChecked =
                $(".checkBox").length === $(".checkBox:checked").length;
            $("#checkAll").prop("checked", allChecked);
        }
    });

    $("th").click(function (e) {
        if (e.target.type !== "checkbox") {
            var checkbox = $(this).find("#checkAll");

            checkbox.prop("checked", !checkbox.prop("checked"));
            checkAllChange();
        }
    });

    $(".checkBox").each(function (i) {
        $(this).change(function () {
            const allChecked =
                $(".checkBox").length === $(".checkBox:checked").length;
            $("#checkAll").prop("checked", allChecked);
        });
    });
});
