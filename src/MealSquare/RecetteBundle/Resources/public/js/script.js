/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


var cache = {};
 
function autocompleteIngredient(selector, selectorId, route){
    selector.autocomplete({
        source: function (request, response)
        {
            //Si la réponse est dans le cache
            if (request.term in cache)
            {
                response($.map(cache[request.term], function (item)
                {
                    return {
                        label:  item.libelle,
                        value: function ()
                        {
                            if (selector.attr('data-id') === 'id')
                            {
                                selector.val(item.libelle);
                                return item.id;
                            }
                            else
                            {
                                selectorId.val(item.id);
                                return item.libelle;
                            }
                        }
                    };
                }));
            }
            //Sinon -> Requete Ajax
            else
            {

                var objData = {};
                var url = route;
                if ($(this.element).attr('data-id') === 'id')
                {
                    objData = { id: request.term };
                }
                else
                {
                    objData = { libelle: request.term };
                }

                $.ajax({
                    url: url,
                    dataType: "json",
                    data : objData,
                    type: 'POST',
                    success: function (data)
                    {
                        //Ajout de reponse dans le cache
                        cache[request.term] = data;

                        response($.map(data, function (item)
                        {
                            return {
                                label: item.libelle,
                                value: function ()
                                {
                                    if (selector.attr('data-id') === 'id')
                                    {
                                        selector.val(item.libelle);
                                        return item.id;
                                    }
                                    else
                                    {
                                        selectorId.val(item.id);
                                        return item.libelle;
                                    }
                                }
                            };
                        }));
                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        console.log(textStatus, errorThrown);
                    }
                });
            }
        },
        minLength: 3,
        delay: 300
    });
}


        
function addFormField(selector) {
    var collectionHolder = $('#' + selector.attr('data-target'));
    var prototype = collectionHolder.attr('data-prototype');
    var form = prototype.replace(/__name__/g, collectionHolder.children().length);

    collectionHolder.append(form);
}

function removeFormField(selector) {
    var name = selector.attr('data-related');
    $('*[data-content="'+name+'"]').remove();
}


