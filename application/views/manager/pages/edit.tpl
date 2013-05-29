{literal}
<script>
    function insertLink(e) {
        var linkEl = document.getElementById('link');
        var titleEl = document.getElementById('title');

        if(titleEl.value != ''){
            var linkValue = textToTranslit(titleEl.value);
            linkValue = linkValue.replace(/[^A-Za-z0-9]/g,'_');
            linkEl.value=linkValue+'.html';

        } else {
            linkEl.value = "";
        }
    }

    function checkForm(){
        var linkEl = document.getElementById('link');
        var titleEl = document.getElementById('title');
        if (titleEl.value == '') {
            alert('Заголовок не может быть пустым.');
            return false;
        }
        if (!linkEl.value.match(/^[A-Za-z0-9_]*\.html$/g)) {
            alert('Алиас должен содержать только латинские буквы, цифры и знак подчеркивания, алиас должен заканчиваться на ".html"');
            return false;
        }
        return true;
    }

    function textToTranslit(textar) {
        var rusLet = new Array("Э","Щ","Щ","Ч","Ч","Ш","Ш","Ё","Ё","Ё","Ё","Ю","Ю","Ю","Ю","Я","Я","Я","Я","Ж","Ж","А","Б","В","Г","Д","Е","З","ИЙ","ИЙ","ЫЙ","ЫЙ","И","Й","К","КС","Л","М","Н","О","П","Р","С","Т","У","Ф","Х","Ц","Щ","Ы","э","щ","ч","ш","ё","ё","ю","ю","я","я","ж","а","б","в","г","д","е","з","ий","ий","ый","ый","и","й","к","кс","л","м","н","о","п","р","с","т","у","ф","х","ц","щ","щ","ы","ъ","ъ","ь");
        var engReg = new Array('E',"Shch","Shch","Ch","Ch","Sh","Sh","YO","JO","Yo","Jo","YU","JU","Yu","Ju","YA","JA","Ya","Ja","ZH","Zh","A","B","V","","D","E","Z","II","IY","YI","YY","I","J","K","X","L","M","N","O","P","R","S","T","U","F","H","C","W","Y","e'","shch","ch","sh","yo","jo","yu","ju","ya","ja","zh","a","b","v","","d","e","z","ii","iy","yi","yy","i","j","k","x","l","m","n","o","p","r","s","t","u","f","h","c","w","#","y","`","~","'");

        if (textar) {
            for (i=0; i < engReg.length; i++){
                textar = textar.replace(rusLet[i], engReg[i]);
            }

            return textar;
        }
    }
</script>
{/literal}
{include file='pages/inc/tabs.tpl'}
<div class="manager-content">

    <div class="manager-header">
        <img src="/images/admin/icons/news.png" alt="" />
        <span>Редактирование страницы</span>
    </div>

    <form action="/manager/pages/update/id/{$request->page_id}" method="post" class="form">
        <div id="tabs" class="ui-tabs ui-widget ui-widget-content ui-corner-all">
            <ul class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all">
                <li class="ui-state-default ui-corner-top ui-tabs-selected ui-state-active">
                    <a href="#tabs-1">English</a>
                </li>
                <li class="ui-state-default ui-corner-top">
                    <a href="#tabs-2">Russian</a>
                </li>
                <li class="ui-state-default ui-corner-top">
                    <a href="#tabs-3">Ukrain</a>
                </li>
            </ul>
            <div id="tabs-1" class="ui-tabs-panel ui-widget-content ui-corner-bottom">
                <div class="form-item">
                    <label>Заголовок:</label>
                    <input id="title_en" type="text" value="{$request->title.en}" name="title[en]" />
                </div>
                <div class="form-item">
                    <label>Описание*:</label>
                    <input type="text" value="{$request->description.en|stripslashes}" name="description[en]" />
                </div>
                <div class="form-item">
                    <label>ключевые слова:*</label>
                    <input type="text" value="{$request->keywords.en|stripslashes}" name="keywords[en]" />
                </div>
                <div class="form-item">
                    <label>Текст:</label>
                    <textarea id="tiny_mce_en" name="body[en]">{$request->body.en|stripslashes}</textarea>
                </div>
            </div>
            <div id="tabs-2" class="ui-tabs-panel ui-widget-contrut ui-corner-bottom ui-tabs-hide">
                <div class="form-item">
                    <label>Заголовок:</label>
                    <input id="title_ru" type="text" value="{$request->title.ru}" name="title[ru]" />
                </div>
                <div class="form-item">
                    <label>Описание*:</label>
                    <input type="text" value="{$request->description.ru|stripslashes}" name="description[ru]" />
                </div>
                <div class="form-item">
                    <label>ключевые слова:*</label>
                    <input type="text" value="{$request->keywords.ru|stripslashes}" name="keywords[ru]" />
                </div>
                <div class="form-item">
                    <label>Текст:</label>
                    <textarea id="tiny_mce_ru" name="body[ru]">{$request->body.ru|stripslashes}</textarea>
                </div>
            </div>
            <div id="tabs-3" class="ui-tabs-panel ui-widget-content ui-corner-bottom ui-tabs-hide">
                <div class="form-item">
                    <label>Заголовок:</label>
                    <input id="title_ua" type="text" value="{$request->title.ua}" name="title[ua]" />
                </div>
                <div class="form-item">
                    <label>Описание*:</label>
                    <input type="text" value="{$request->description.ua|stripslashes}" name="description[ua]" />
                </div>
                <div class="form-item">
                    <label>ключевые слова:*</label>
                    <input type="text" value="{$request->keywords.ua|stripslashes}" name="keywords[ua]" />
                </div>
                <div class="form-item">
                    <label>Текст:</label>
                    <textarea id="tiny_mce_ua" name="body[ua]">{$request->body.ua|stripslashes}</textarea>
                </div>
            </div>

            <div class="form-item">
                <label>alias:*</label>
                <input id="link" type="text" value="{$request->link}" name="link" />
            </div>
            <div>
                <input onclick="return checkForm();" type="submit" value="Сохранить" />
            </div>
        </div>
    </form>
</div>