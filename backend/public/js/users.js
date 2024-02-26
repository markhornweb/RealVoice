$(document).ready(function() {
    $('#searchForm input').on('keyup', function() {
        let userName = $('#userName').val();
        let nickName = $('#nickName').val();
        let userEmail = $('#userEmail').val();
        $.get('usersSearch', {
            "userName": userName,
            "nickName": nickName,
            "userEmail": userEmail
        }, (res) => {
            $('#user-list').html(res);
        });
    });
});