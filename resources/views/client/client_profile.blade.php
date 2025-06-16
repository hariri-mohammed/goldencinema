<style>
    :root {

        --second-color: #ff9e1b;
        --darker-color: #e6ee0d;
        --text-color: #343a40;
    }

    /* body {
        background: var(--main-color);
        color: var(--text-color);
        font-family: 'Tajawal', sans-serif;
        margin: 0;
        padding: 0;
    } */

    .under-nav {
        padding-top: 70px;
        /* تقليل الهامش العلوي قليلاً */
        min-height: calc(100vh - 70px);
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .info-container {
        max-width: 700px;
        /* تقليل العرض الأقصى للحاوية */
        width: 90%;
        background: #fff;
        border-radius: 7px;
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.3);
        padding: 15px;
        /* تقليل حجم التباعد الداخلي */
    }

    .main-title {
        margin-bottom: 15px;
        text-align: center;
    }

    .my-icon {
        display: flex;
        justify-content: center;
        margin-bottom: 8px;
    }

    .circle {
        height: 80px;
        /* تقليل حجم الدائرة */
        width: 80px;
        border-radius: 50%;
        border: 2px solid var(--second-color);
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .circle i {
        color: var(--second-color);
        font-size: 3em;
        /* تقليل حجم الأيقونة */
    }

    .line {
        width: 150px;
        /* تقليل عرض الخط */
        background-color: var(--second-color);
        height: 2px;
        margin: 8px auto;
    }

    .rows {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 0px;
        justify-items: center;
        /* تقليل التباعد بين العناصر */
    }

    .info-field {
        margin-bottom: 10px;
    }

    .title-field {
        display: flex;
        align-items: center;
    }

    .title-field .circle {
        height: 40px;
        /* تقليل حجم دائرة العنوان */
        width: 40px;
    }

    .title-field i {
        font-size: 1.2em;
        /* تقليل حجم أيقونة العنوان */
    }

    .title-field h4 {
        margin-left: 8px;
        font-size: 1em;
        /* تقليل حجم عنوان الحقل */
        font-weight: 600;
    }

    .info-field p {
        margin-left: 50px;
        /* تقليل الهامش الأيسر للنص */
        font-size: 1em;
        /* تقليل حجم النص */
    }

    .btn {
        background-color: var(--second-color);
        border-color: var(--second-color);
        color: white;
        font-weight: 600;
        font-size: 0.9em;
        /* تقليل حجم الخط في الزر */
        padding: 8px 12px;
        /* تقليل حجم التباعد الداخلي للزر */
    }

    .btn:hover {
        background-color: var(--darker-color);
        border-color: var(--darker-color);
    }

    .custom-alert {
        padding: 8px;
        margin-top: 8px;
        text-align: center;
        font-size: 0.9em;
        /* تقليل حجم الخط في التنبيهات */
        font-weight: 600;
        border-radius: 5px;
    }

    .alert-success {
        background-color: #d4edda;
        color: #155724;
    }

    .alert-danger {
        background-color: #f8d7da;
        color: #721c24;
    }
</style>

{{-- @include('layouts.visetor_sit_nav') --}}

<div class="under-nav">
    <div class="info-container">
        <div class="main-title">
            <div class="my-icon">
                <div class="circle">
                    <i class="fa fa-user fa-4x"></i>
                </div>
            </div>
            <h2>{{ ucfirst($client->username) }}'s Information</h2>
            <span class="line"></span>
        </div>

        <div class="rows">
            <div class="info-field">
                <div class="title-field">
                    <div class="circle">
                        <i class="fas fa-user"></i>
                    </div>
                    <h4>Full Name</h4>
                </div>
                <p>{{ ucfirst($client->first_name) }} {{ ucfirst($client->last_name) }}</p>
            </div>

            <div class="info-field">
                <div class="title-field">
                    <div class="circle">
                        <i class="fa fa-user fa-fw"></i>
                    </div>
                    <h4>Username</h4>
                </div>
                <p>{{ $client->username }}</p>
            </div>

            <div class="info-field">
                <div class="title-field">
                    <div class="circle">
                        <i class="fa fa-envelope fa-fw"></i>
                    </div>
                    <h4>E-mail</h4>
                </div>
                <p>{{ $client->email }}</p>
            </div>

            <div class="info-field">
                <div class="title-field">
                    <div class="circle">
                        <i class="fa fa-phone fa-fw"></i>
                    </div>
                    <h4>Phone Number</h4>
                </div>
                <p>{{ $client->phone_number }}</p>
            </div>

            <div class="info-field">
                <div class="title-field">
                    <div class="circle">
                        <i class="fa fa-birthday-cake fa-fw"></i>
                    </div>
                    <h4>Date of Birth</h4>
                </div>
                <p>{{ $client->date_of_birth ? $client->date_of_birth->format('Y-m-d') : 'N/A' }}</p>
            </div>

            <div class="info-field">
                <div class="title-field">
                    <div class="circle">
                        <i class="fas fa-genderless"></i>
                    </div>
                    <h4>Gender</h4>
                </div>
                <p>{{ $client->gender ?? 'N/A' }}</p>
            </div>

        </div>


    </div>
</div>
