"use strict";
require('./bootstrap');

    const formElement = document.querySelector('.fn_register');
    if (formElement){
        formElement.addEventListener("submit", function (event) {
            event.preventDefault();
//
            let errorModalElements = document.getElementById('errorModal');
            let errorModal = new bootstrap.Modal(errorModalElements,{
                close: true,
                keyboard: true
            });
            const form = this
//
            const data = new FormData(form)
            const url = form.getAttribute('action')
            const method = form.getAttribute('method')
//
            axios({
                method: method,
                url: url,
                data: data,
                headers: {'Content-Type': 'multipart/form-data'}
            })
                .then(function (response) {
                    alert('Successfully logged-in');
//
//             // Reload page so you will be redirected to default page defined in Laravel
            window.location.reload()
                })
                //
                .catch(function (error) {
                    let message = 'An error occured.'; // Default error message
                    if (typeof error.response !== 'undefined' && typeof error.response.data !== 'undefined') {
//                 // Error message from server
                        if (typeof error.response.data.message !== 'undefined')
                            message = error.response.data.message
                        // Access input errors using:
                        if (typeof error.response.data.errors !== 'undefined') {
                            let errors = error.response.data.errors
                            for (let input in errors) {
                                if (errors.hasOwnProperty(input)) {
                                    errorModalElements.getElementsByClassName('modal-body')[0].innerHTML += errors[input].join('<br/>')+'<br/>'
                                }
                            }
                        }
                    }
                    errorModalElements.getElementsByClassName('modal-title')[0].innerHTML = message;
                    errorModal.show();
                    $("#btnClosePopup").click(function () {
                        errorModal.hide();
                    });
                })
        });
    }

const formAddTaskElement = document.querySelector('.fn_addTask');
let containerTasks = document.getElementById('fn_desk_to_task');
if (formAddTaskElement){
    formAddTaskElement.addEventListener("submit", function (event) {
        event.preventDefault();

        const form = this
        const data = new FormData(form)
        const url = form.getAttribute('action')
        const method = form.getAttribute('method')

        axios({
            method: method,
            url: url,
            data: data,
            headers: {'Content-Type': 'multipart/form-data'}
        })
            .then(function (response) {
                // console.log(response.data);
                // console.log(response.data.name);

//             // Reload page so you will be redirected to default page defined in Laravel
//                 window.location.reload()
            }).catch(function (error) {
                let message = 'An error occured.'; // Default error message
                if (typeof error.response !== 'undefined' && typeof error.response.data !== 'undefined') {
//                 // Error message from server
                    if (typeof error.response.data.message !== 'undefined')
                        message = error.response.data.message
                    // Access input errors using:
                    if (typeof error.response.data.errors !== 'undefined') {
                        let errors = error.response.data.errors
                        for (let input in errors) {
                            if (errors.hasOwnProperty(input)) {
                                // errorModalElements.getElementsByClassName('modal-body')[0].innerHTML += errors[input].join('<br/>')+'<br/>'
                                console.log(errors[input].join('<br/>')+'<br/>')
                            }
                        }
                    }
                }
                console.log(message);
            })
    });
}

if (containerTasks) {
    containerTasks.addEventListener('click',function (e) {
        let item = e.target;
        if(!item.dataset.name){
            return true;
        }
       let stringWork = item.closest('tr');
       let id = stringWork.getAttribute('id');


       updateStatus(id,item.dataset.name).then(function (response) {
           if (!response.status){
               console.log(response)
               console.log('dfs');
               return false;
           }
            if (response.status === 'to_work'){
                stringWork.classList.remove("bg-light");
                stringWork.classList.add("bg-info");
                let sota = stringWork.querySelector('tr > td.to-work');
                sota.innerHTML = 'to finish';
                sota.dataset.name = 'finished';
            }else if (response.status === 'finished'){
                    stringWork.classList.remove("bg-info");
                    stringWork.classList.add("bg-success");
                    let sota = stringWork.querySelector('tr > td.to-work');
                    sota.innerHTML = 'Ok';
                    sota.dataset.name = 'cancel_finished';
            }else if(response.status === 'archive'){
                stringWork.parentNode.removeChild(stringWork);
            }
        });
    })
}

function updateStatus(id,status) {

    const data = new FormData()
    const url = '/task/update'
    const method = 'post'
    data.set('id', id);
    data.set('status', status);
    return axios({
    method: method,
    url: url,
    data: data,
    headers: {
        'X-Requested-With': 'XMLHttpRequest',
        'Content-Type': 'multipart/form-data'
    }
}).then(function (response) {
        return response.data;
    }).catch(function (error) {
        console.log(error.response.data.message);
         return error.response.data;
//         let message = 'An error occured.'; // Default error message
//         if (typeof error.response !== 'undefined' && typeof error.response.data !== 'undefined') {
// //                 // Error message from server
//             if (typeof error.response.data.message !== 'undefined')
//                 message = error.response.data.message
//             // Access input errors using:
//             if (typeof error.response.data.errors !== 'undefined') {
//                 let errors = error.response.data.errors
//                 for (let input in errors) {
//                     if (errors.hasOwnProperty(input)) {
//                         // errorModalElements.getElementsByClassName('modal-body')[0].innerHTML += errors[input].join('<br/>')+'<br/>'
//                         console.log(errors[input].join('<br/>') + '<br/>')
//                     }
//                 }
//             }
//         }
    });
}

Echo.channel(`trades`)
    .listen('TaskStatusUpdated', (e) => {
        if (e.id && e.status === 'new'){
          let html = ' <tr class=" bg-light " id="'+e.id+'" data-id="'+e.id+'">\n' +
                '                            <th scope="row">'+e.id+'</th>\n' +
                '                            <td >'+e.name_task+'</td>\n' +
                '                            <td data-name="to_work" class="to-work"><i class="fas fa-safari" aria-hidden="true" data-name="to_work">to work</i></td>\n' +
                '                            <td class="to-delete"><i class="far fa-trash" aria-hidden="true" >to trash</i></td>\n' +
                '                        </tr>';
            containerTasks.innerHTML+=html;
        }
    });

Echo.channel(`task_status`)
    .listen('TaskStatusUpdatedOk', (e) => {
        if (e.id && e.status === 'to_work'){
            let rowTable = containerTasks.querySelector('[data-id="'+e.id+'"]');
            if (rowTable){
                rowTable.classList.remove("bg-light");
                rowTable.classList.add("bg-info");
                let sota = rowTable.querySelector('tr > td.to-work');
                sota.innerHTML = 'to finish';
                sota.dataset.name = 'finished';
            }
        }else if (e.id && e.status === 'finished'){
            let rowTable = containerTasks.querySelector('[data-id="'+e.id+'"]');
            if (rowTable){
                rowTable.classList.remove("bg-info");
                rowTable.classList.add("bg-success");
                let sota = rowTable.querySelector('tr > td.to-work');
                sota.innerHTML = 'Ok';
                sota.dataset.name = 'cancel_finished';
            }
        }else if (e.id && e.status === 'archive'){
            let rowTable = containerTasks.querySelector('[data-id="'+e.id+'"]');
            if (rowTable){
                rowTable.parentNode.removeChild(rowTable);
            }
        }
    });
