function clickOnCreate(Obj) {
    const tr = $(Obj).parents("tr");
    const str = tr[0].innerHTML;
    tr.after("<tr>" + str + "</tr>");
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
        const listName = $(this)[0].className.split(' ')[2];
        const list = eval(listName);

        let html = '<select class=custom-select>';

        Object.keys(list).forEach(function(key){
            if (key === 1) {
                html += '<option selected value=' + key + '>' + list[key] + '</option>';
            } else {
                html += '<option value=' + key + '>' + list[key] + '</option>';
            }
        });
        html = html + '</select>';
        $(this).html(html);
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
        const listName = $(this)[0].className.split(' ')[2];
        const list = eval(listName);

        const text = $(this).text();
        let num;
        Object.keys(list).forEach(function(key){if (list[key] === text) num = key;});

        let html = '<select class=custom-select>';

        Object.keys(list).forEach(function(key){
            if (num === key) {
                html += '<option selected value=' + key + '>' + list[key] + '</option>';
            } else {
                html += '<option value=' + key + '>' + list[key] + '</option>';
            }
        });
        html = html + '</select>';
        $(this).html(html);
    });
}

function clickOnDelete(Obj) {
    if (true === confirm('Do you want to delete, it can\'t be restore')) {
        $.post(window.location.href, {id: $(Obj).parents("tr").find('.id').html(), action: 'delete'},
            function (data) {
            if (data === 'success') location.reload();
            else alert(data);})
    }
}

function clickOnSave(Obj) {
    const tr = $(Obj).parents("tr");

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
        //$(this).html(input.value);
    });

    tr.find('.selectTF').each(function () {
        const name = $(this)[0].className.split(' ')[1];
        const checked = $(':radio[name="' + name + '"]:checked').val();
        post_date[name] = checked;
        //if (checked === '0') $(this).html('No');
        //else $(this).html('Yes');
    });

    tr.find('.selectL').each(function () {
        const name = $(this)[0].className.split(' ')[1];
        const selected = $('select').val();
        post_date[name] = selected;
    });

    if (post_date !== {}) {
        $.post(window.location.href, Object.assign({action: 'save'}, post_date), function (data) {
            if (data === 'success') location.reload();
            else alert(data);
        });
    }

}