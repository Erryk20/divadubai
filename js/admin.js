$(document).ready(function () {
    
//    if($('.panel-footer ul.pagination').length != 0){
//        $('.panel-footer ul.pagination li a').click(function(){
//            event.preventDefault();
//            console.log(this);
//        });
//        
//    }

    
    $('.fillter-admin select#filterformadmin-category_id').livequery('change', function () {
        var category_id = $(this).val();
        var url = $(this).data('url');
        
        var data = (category_id != '') ? "?FilterFormAdmin[category_id]="+category_id : '';
        var resultUrl = url + data;



        history.pushState(null, null, resultUrl);
        
        $.ajax({
            url: resultUrl,
            type: 'GET',
            success: function(request){
                $('#advance-block').html(request);
          }
        });
    });

    $('#crud-datatable-container tbody input[type=checkbox]').livequery('click', function(){
        var search = getUrl($(this));

        setPagination(search);
        setForMail(search);
        
        history.pushState(null, null, search);
    });
    
    $('.select-on-check-all').livequery('click', function(){
        var el = this;
        var items = [];

        if($(el).prop("checked")){
            setTimeout(function () {
                $.each($('tr.danger input[type="checkbox"]'), function(key, value ) {
                    items[key] = $(this).val();
                });

                var search = getUrl(el, items);

                setPagination(search);
                setForMail(search);
                
                history.pushState(null, null, search);
            }, 500);     
        }else{
            $.each($('tr.danger'), function( key, value ) {
                items[key] = $(value).data('key');
            });

            var search = getUrl(el, items);
            if(search == ''){
                search = window.location.pathname;
            }

            setPagination(search);
            setForMail(search);

            history.pushState(null, null, search);
        }

        
        
    });
    

});

function setForMail(search){
    if($('.add-checked').length != 0){
        var href = $('.add-checked').attr('href');
        var link = href.match(/(^.*?)\?/);

        if(link == undefined){
            link = href;
        }else{ 
            link = link[1];
        }

        var checked = search.match(/checked=(\d+|,)+/);

        if(checked != undefined){
            $('.add-checked').attr('href', link+"?"+checked[0]) ;
        }else{
            $('.add-checked').attr('href', link) ;
        }
    }
}



function getUrl(el, elements = null){
    var id = +$(el).val();
        
    var search = window.location.search;
    var checked = (search.match(/\?/) !== null) ? '&' : '?';
    checked += 'checked=';



    if(search.match(/checked/)){
        var match = search.match(/checked=((\d+|,|%2C)*)/);
        
        var list = (match != undefined) ? match[1].split(new RegExp(/,|%2C/)) : [];

        $.each(list, function(key, val){list[key] = +val;});

        var count = list.length;

        if($(el).prop("checked")){
            if(elements == null){
                list[count] = id;
            }else{
              list = _.union(list, elements);
            }
        }else{
            if(elements == null){
                list.splice(list.indexOf(id), 1);
            }else{
                var list = _.difference(list, elements);
            }
        }

        if(list.length == 0){
             search = search.replace(/.{1}checked=((\d+|,|%2C)*)/, '');
             search = search.replace(/^&/, '?');
        }else{

            checked = 'checked=' + list.toString();
            search = search.replace(/checked=((\d+|,|%2C)*)/, checked);
        }

        return search
    }else{
        if(elements == null){
           return search + checked + id
        }else{
           return search + checked + elements;
        }
   }

}

function setPagination(search){
    var checked = search.match(/checked=((\d+|,|%2C)*)/);
    $('ul.pagination li a').livequery(function(e){
        var link = $(this).attr('href');

        if(link.match(/checked/)){
            if(checked == null){
                link = link.replace(/.{1}checked=((\d+|,|\%2C)*)/, "");   
            }else{
                link = link.replace(/checked=((\d+|,|\%2C)*)/, "checked="+checked[1]);    
            }
            $(this).attr('href', link);   
        }else{
            $(this).attr('href', link+'&checked='+checked[1]);    
        }
    });
}

function CollectID(){
    var search = window.location.search.match(/checked=((\d+|,|%2C)*)/);
    if(search != null){
        var list = [];
        if(search[1].match(/%2C/)){
            list = search[1].split('%2C');
        }else{
            list = search[1].split(',');
        }

        var result = JSON.stringify(list);    
        $('#email-itemsid').val(result);
    }
}