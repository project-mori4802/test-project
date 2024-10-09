// 処理成功時のモーダル表示処理
$(document).ready(function() {
    $(document).ready(function() {
        const successMessage = $('#success-message');
        console.log(successMessage);
        if (successMessage.length) {
            Swal.fire({
                icon: 'success',
                title: '成功',
                text: successMessage.text(),
            });
        }
    });
});