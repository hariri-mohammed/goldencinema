@foreach ($groupedShows as $date => $locations)
    <div class="showtime-date">
        <h4>{{ $date }}</h4> <!-- تأكد أن $date هو نص وليس مصفوفة -->
        @foreach ($locations as $location => $times)
            <div class="showtime-location">
                <h5>{{ $location }}</h5> <!-- تأكد أن $location هو نص وليس مصفوفة -->
                <ul>
                    @foreach ($times as $time)
                        <li>{{ $time }}</li> <!-- تأكد أن $time هو نص وليس مصفوفة -->
                    @endforeach
                </ul>
            </div>
        @endforeach
    </div>
@endforeach
