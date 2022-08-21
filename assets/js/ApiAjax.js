function CallAPI(Method,link, data) {

    return new Promise((resolve, reject) => {

        $.ajax({
            type: Method,
            url: link,
            // contentType: 'application/json; charset=utf-8',
            data: data,
            dataType: 'json',
            success: function (response) {
                // var data = jQuery.parse(response.d)
                resolve(response)
            },
            error: (err) => {
                //console.log(err)
                reject(err)
            }
        })

    })
}
