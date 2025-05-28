
<style>

.contact-form {
    background: #fff;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    width: 100%;
    max-width: 400px;
}

.contact-form h2 {
    margin-bottom: 20px;
    text-align: center;
}

.contact-form form input,
.contact-form form textarea,
.contact-form form button {
    width: 100%;
    margin-bottom: 15px;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.contact-form form button {
    background: #007BFF;
    color: white;
    border: none;
    font-size: 16px;
    cursor: pointer;
    width: auto;
    padding: 10px 30px 10px 30px;
}

.contact-form form button:hover {
    background: #0056b3;
}

</style>


<x-layout>
   <div class="container">
          <div class="page-inner">
            <div class="page-header">
              <h3 class="fw-bold mb-3">Help Center</h3>
              <ul class="breadcrumbs mb-3">
                <li class="nav-home">
                  <a href="/">
                  <i class="fas fa-house"></i>
                  </a>
                </li>
                <li class="separator">
                <i class="fa-solid fa-arrow-right"></i>
                </li>
                <li class="nav-item">
                  <a href="/">Home</a>
                </li>
                <li class="separator">
                <i class="fa-solid fa-arrow-right"></i>
                </li>
                <li class="nav-item">
                  <a href="/helpcenter">Help Center</a>
                </li>
              </ul>
            </div>


            <div class="row" style="place-content: center; margin-top: 50px;">
       
            <div class="col-lg-6 contact-form">
              @if(session('success'))
              <div class="alert alert-success">{{ session('success') }}</div>
              @endif
             @if ($errors->any())
              <div class="alert alert-danger">
                  <ul class="mb-0">
                      @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                      @endforeach
                  </ul>
              </div>
          @endif
        <h2>Contact Us</h2>
        <form action="{{route('submit.enquiry')}}" method="POST" enctype="multipart/form-data">
          @csrf
            <input class="form-control" type="text" name="name" placeholder="Name" value="{{ old('name') }}" required>

            <input class="form-control" type="email" name="email" placeholder="Email" value="{{ old('email') }}" required>

            <input class="form-control" type="tel" name="phone" placeholder="Phone" value="{{ old('phone') }}" required>

            <input class="form-control" type="text" name="subject" placeholder="Subject" value="{{ old('subject') }}" required>

            <textarea class="form-control" name="message" rows="5" placeholder="Message">{{ old('message') }}</textarea>

            <input class="form-control" type="file" name="file">


            <div class="mt-3 text-center">
            <button type="submit" class="btn btn-danger">Submit</button>
</div>
        </form>
    </div>
            </div>
          </div>
   </div>
</x-layout>