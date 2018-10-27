function clickOnCreate(Obj) {
    const tr = $(Obj).parents("tr");
    console.log($(Obj));
    var str = tr[0].innerHTML;
    tr.after("<tr>" + str + "</tr>");
    console.log(str);
    tr.find('.table-save').show(); tr.find('.table-create').hide();

    tr.find('.text').each(function () {
        tr.find('.text').each(function () {
            $(this).html("<input class='form-control' type='text' maxlength='40'/>");
        });
    });

    tr.find('.selectTF').each(function () {
        const name = $(this)[0].className.split(' ')[1];
        $(this).html(
            "<label class=\"radio-inline\"><input type=\"radio\" name=\"" + name +"\" value=\"0\">No</label>" +
            "<label class=\"radio-inline\"><input checked type=\"radio\" name=\"" + name +"\" value=\"1\">Yes</label>"
        );
    });

    tr.find('.selectL').each(function () {

    });

}

function clickOnModify(Obj) {
    const tr = $(Obj).parents("tr");
    tr.find('.table-save').show();
    tr.find('.table-update').hide(); tr.find('.table-delete').hide();

    tr.find('.text').each(function () {
        $(this).html("<input class='form-control' type='text' maxlength='40' value='" + $(this).text() + "'/>");
    });

    tr.find('.selectTF').each(function () {
        const name = $(this)[0].className.split(' ')[1];
        let val = 1;
        if ($(this)[0].innerHTML === 'No') {
            val = 0;
        }
        $(this).html(
            "<label class=\"radio-inline\"><input type=\"radio\" name=\"" + name +"\" value=\"0\">No</label>" +
            "<label class=\"radio-inline\"><input type=\"radio\" name=\"" + name +"\" value=\"1\">Yes</label>"
        );

        $(':radio[name=' + name + ']').eq(val).attr("checked",true);
    });

    tr.find('.selectL').each(function () {

    });
}

function clickOnDelete(Obj) {
    if (true === confirm('Do you want to delete, it can\'t be restore')) {
        $.post(window.location.href, {id: $(Obj).parents("tr").find('.id').html(), action: 'delete'},
            function (data) {$(Obj).parents("tr").hide(); })
    }
}

function clickOnSave(Obj) {
    const tr = $(Obj).parents("tr");
    tr.find('.table-save').hide();
    tr.find('.table-update').show(); tr.find('.table-delete').show(); tr.find('.table-create').show();
    let post_date = {};

    tr.find('.id').each(function () {
        if ($(this)[0].innerHTML !== '') post_date.id = $(this)[0].innerHTML;
    });

    tr.find('.text').each(function () {
        const td = $(this)[0];
        const input = $(td.lastChild)[0];
        if (input.value !== '') {
            post_date[td.className.split(' ')[1]] = input.value;
        }
        $(this).html(input.value);
    });

    tr.find('.selectTF').each(function () {
        const name = $(this)[0].className.split(' ')[1];
        const checked = $(':radio[name="' + name + '"]:checked').val();
        post_date[name] = checked;
        if (checked === '0') $(this).html('No');
        else $(this).html('Yes');
    });

    tr.find('.selectL').each(function () {

    });

    if (post_date !== {}) {
        $.post(window.location.href, Object.assign({action: 'save'}, post_date), function () {
            location.reload();
        });
    }
}