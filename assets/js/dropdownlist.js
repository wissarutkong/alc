function getddl(Id,Service) {
    return new Promise((resolve, reject) => {
        $('#' + Id + '').empty()
        $('#' + Id + '').append('<option value="">Loading...</option>')
        //$('#' + Id + '').select2('refresh')
        CallAPI('POST','../../service/'+Service+'/getddl.php',
                ''
        ).then((data) => {
            $('#' + Id + '').html(data)
            $('#' + Id + '').trigger('change');
            resolve()
        }).catch((error) => {
            toastr.error(error.status)
            reject()
        })
    })
}

function getddlbyelement(Id,Service) {
    return new Promise((resolve, reject) => {
        $('' + Id + '').empty()
        $('' + Id + '').append('<option value="">Loading...</option>')
        //$('#' + Id + '').select2('refresh')
        CallAPI('POST','../../service/'+Service+'/getddl.php',
                ''
        ).then((data) => {
            $('' + Id + '').html(data)
            $('' + Id + '').trigger('change');
            resolve()
        }).catch((error) => {
            toastr.error(error.status)
            reject()
        })
    })
}

function getddlbyId(Id,Service,conditions) {
    return new Promise((resolve, reject) => {
        $('#' + Id + '').empty()
        $('#' + Id + '').append('<option value="">Loading...</option>')
        //$('#' + Id + '').select2('refresh')
        CallAPI('POST','../../service/'+Service+'/getddl.php',
                { id : conditions}
        ).then((data) => {
            $('#' + Id + '').html(data)
            $('#' + Id + '').trigger('change');
            resolve()
        }).catch((error) => {
            toastr.error(error.status)
            reject()
        })
    })
}


