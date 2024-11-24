@extends('layout')
@section('content')
<div class="container">
    <h1>Thống kê cho bác sĩ: {{ $doctor->user->name }}</h1>

    
    <div>
        
        <div class="charts-container" style="display: flex;">
            
            <canvas id="revenueChart" style="width:60%; max-width:500px;"></canvas>

            
            <canvas id="lostRevenueChart" style="width:60%; max-width:500px;"></canvas>
        </div>

        
         
        <div class="chart-container" style="display: flex; margin-top: 10px;">
            
            <canvas id="appointmentsChart" style="width:100%;max-width:500px"></canvas>

            
            <canvas id="averageRatingChart" style="width:50%; max-width:500px;"></canvas>
        </div>
    </div>

    <div class="statistics-section">
    <h3>Thông kê đánh giá của bệnh nhân</h3>
    
    <div class="review-counts">
        <p><strong>Những đánh giá tốt (4-5 stars):</strong> {{ $positiveReviewsCount }}</p>
        <p><strong>Những đánh giá trung bình (3 stars):</strong> {{ $neutralReviewsCount }}</p>
        <p><strong>Những đánh giá không tốt (1-2 stars):</strong> {{ $negativeReviewsCount }}</p>
    </div>

    <div class="statistics-section">
        <h3>Review Summary</h3>
        <canvas id="reviewChart" width="400" height="200"></canvas>
    </div>

</div>

</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
<script>
   
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    new Chart(revenueCtx, {
        type: 'bar',
        data: {
            labels: ['Doanh thu'],
            datasets: [{
                label: 'Tổng doanh thu (VND)',
                data: [{{ $totalRevenue }}],
                backgroundColor: 'rgba(75, 192, 192, 0.6)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        }
    });


    const ctx = document.getElementById('reviewChart').getContext('2d');
    const reviewChart = new Chart(ctx, {
        type: 'pie', 
        data: {
            labels: ['Đánh giá tích cực', 'Đánh giá trung bình', 'Đánh giá tệ'],
            datasets: [{
                label: 'Review Counts',
                data: [
                    {{ $positiveReviewsCount }},
                    {{ $neutralReviewsCount }},
                    {{ $negativeReviewsCount }}
                ],
                backgroundColor: [
                    'rgba(75, 192, 192, 0.6)', 
                    'rgba(255, 206, 86, 0.6)',  
                    'rgba(255, 99, 132, 0.6)'  
                ],
                borderColor: [
                    'rgba(75, 192, 192, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(255, 99, 132, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Review Summary by Rating'
                }
            }
        }
    });


    const lostRevenueLabels = ["Thất thu"];
    const lostRevenueData = [{{ $lostRevenue }}]; 
    const lostRevenueColors = ["#FF5733"]; 

    new Chart("lostRevenueChart", {
        type: "bar",
        data: {
            labels: lostRevenueLabels,
            datasets: [{
                label: 'Tổng thất thu (VND)',
                data: lostRevenueData,
                backgroundColor: lostRevenueColors,
                borderColor: lostRevenueColors,
                borderWidth: 1
            }]
        },
        options: {
            title: {
                display: true,
                text: "Thống kê thất thu"
            }
        }
    });

   
    const averageRatingCtx = document.getElementById('averageRatingChart').getContext('2d');
    new Chart(averageRatingCtx, {
        type: 'doughnut',
        data: {
            labels: ['Trung bình số sao'],
            datasets: [{
                label: 'Trung bình số sao',
                data: [{{ $averageRating }}],
                backgroundColor: ['#FFCE56'],
            }]
        },
        options: {
            title: {
                display: true,
                text: "Trung bình số sao của đánh giá"
            }
        }
    });

    
    const appointmentLabels = ["Bình luận", "Lịch khám hoàn tất", "Lịch khám bị hủy"];
    const appointmentData = [{{ $totalComments }}, {{ $completedAppointments }}, {{ $cancelledAppointments }}];
    const appointmentColors = ["#FF6384", "#36A2EB", "#FFCE56"];

    new Chart("appointmentsChart", {
        type: "doughnut",
        data: {
            labels: appointmentLabels,
            datasets: [{
                backgroundColor: appointmentColors,
                data: appointmentData
            }]
        },
        options: {
            title: {
                display: true,
                text: "Thống kê số lượng bình luận và lịch khám"
            }
        }
    });
</script>
@endsection