@component('mail::message')
# Học viện kỹ thuật mật mã
@component('mail::panel')
    <div class="alert alert-success" role="alert">
        <h4 class="alert-heading">Kính gửi: Anh/chị {{ $student->name }}</h4>
        <p>Thông tin của bạn đã được chúng tôi cập nhật.</p>
        <hr>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Họ và tên</th>
                <th scope="col">Địa chỉ email</th>
                <th scope="col">Số điện thoại</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td scope="row"><b>{{ $student->id }}</b></td>
                <td>{{ $student->name }}</td>
                <td>{{ $student->email }}</td>
                <td>{{ $student->phone }}</td>
            </tr>
            </tbody>
        </table>
        <b>Bạn vui lòng đăng nhập tài khoản với email là:{{ $user->email }} và mật khẩu là:123456789</b>
        <b>Vui lòng đổi mật khẩu sau khi đăng nhập để đảm bảo an toàn</b>
    </div> 
@endcomponent

Thanks,{{$student->name}} 
{{ config('app.name') }}
@endcomponent
