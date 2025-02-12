<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <title>Vidyagxp - Software</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            height: 100vh;
        }

        h1 {
            text-align: center;
            margin-top: 20px;
            font-size: 28px;
            color: #343a40;
            font-weight: bold;
        }

        .chart-container {
            width: 100%;
            background: #fff;
            box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            padding: 25px;
            margin: 30px 0;
            transition: all 0.3s ease;
        }

        .chart-container:hover {
            box-shadow: 0px 12px 30px rgba(0, 0, 0, 0.15);
            transform: translateY(-5px);
        }

        .main-header {
            width: 100%;
            background: linear-gradient(45deg, #4e73df, #1cc88a);
            padding: 15px;
            border-radius: 8px;
            color: white;
            margin-top: 10px;
            text-align: center;
        }

        .chart {
            margin: 15px 0;
        }

        /* Add smooth transitions to all charts */
        .apexcharts-canvas {
            animation: fadeIn 1s ease-in-out;
        }

        @keyframes fadeIn {
            0% {
                opacity: 0;
                transform: scale(0.9);
            }
            100% {
                opacity: 1;
                transform: scale(1);
            }
        }

        /* Customize the chart title */
        .apexcharts-title {
            font-size: 24px;
            color: #333;
            font-weight: bold;
        }

        /* Add some spacing between the charts */
        .chart-container {
            margin-bottom: 30px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row">
    @if ($hasInductionData)
    <div class="col-md-6">
        <div class="main-header">
            <h1>Induction Training</h1>
        </div>
        <div class="chart-container">
            <div id="inductionChart" class="chart"></div>
        </div>
    </div>
    @endif

    @if ($hasOnJobData)
    <div class="col-md-6">
        <div class="main-header">
            <h1>On The Job Training</h1>
        </div>
        <div class="chart-container">
            <div id="onJobChart" class="chart"></div>
        </div>
    </div>
    @endif

    @if ($hasClassroomData)
    <div class="col-md-6">
        <div class="main-header">
            <h1>Classroom Training</h1>
        </div>
        <div class="chart-container">
            <div id="classroomChart" class="chart"></div>
        </div>
    </div>
    @endif
    {{-- @dd($hasTNIMatrixData) --}}

    @if ($hasTNIMatrixData)
    <div class="col-md-6">
        <div class="main-header">
            <h1>TNIMatrix Training</h1>
        </div>
        <div class="chart-container">
            <div id="TNIMatrixChart" class="chart"></div>
        </div>
    </div>
    @endif

    @if ($hastniemployeeData)
    <div class="col-md-6">
    <div class="main-header">
        <h1>TNI Employee Training</h1>
    </div>
    <div class="chart-container">
        <div id="TNIEMPMatrixChart" class="chart"></div>
    </div>
</div>
    @endif

    @if ($hastniemployeeData)
    <div class="col-md-6">
    <div class="main-header">
        <h1>Department Wise Job Role Training</h1>
    </div>
    <div class="chart-container">
        <div id="deparmentWiseChart" class="chart"></div>
    </div>
</div>
    @endif
</div>
</div>
    





    <script>
        @if ($hasTNIMatrixData)
            const tnimatrixData = @json($tniMatrixTraining);
            console.log(tnimatrixData); // Optional: logs data to the browser console for further inspection.
    
            const categoriesTNIMatrix = tnimatrixData.map(item => `Training ID: ${item.training_id}`);
            const totalQuestionsTNIMatrix = tnimatrixData.map(item => item.total_questions);
            const correctAnswersTNIMatrix = tnimatrixData.map(item => item.correct_answers);
            const incorrectAnswersTNIMatrix = tnimatrixData.map(item => item.incorrect_answers);
    
            var tnimatrixChartOptions = {
                chart: { type: 'bar', height: 400, toolbar: { show: false } },
                series: [
                    { name: 'Total Questions', data: totalQuestionsTNIMatrix },
                    { name: 'Correct Answers', data: correctAnswersTNIMatrix },
                    { name: 'Incorrect Answers', data: incorrectAnswersTNIMatrix }
                ],
                xaxis: { categories: categoriesTNIMatrix },
                title: { text: 'TNI Matrix Training Results', align: 'center' },
                plotOptions: { bar: { horizontal: false, columnWidth: '50%' } }
            };
    
            var TNIMatrixChart = new ApexCharts(document.querySelector("#TNIMatrixChart"), tnimatrixChartOptions);
            TNIMatrixChart.render();
        @endif
   
        @if ($hastniemployeeData)
            const tniEmployeeData = @json($tniMatrixTraining);
            console.log(tniEmployeeData); // Optional: logs data to the browser console for further inspection.
    
            const categoriesTNIempMatrix = tniEmployeeData.map(item => `Training ID: ${item.training_id}`);
            const totalQuestionsTNIempMatrix  = tniEmployeeData.map(item => item.total_questions);
            const correctAnswersTNIempMatrix  = tniEmployeeData.map(item => item.correct_answers);
            const incorrectAnswersTNIempMatrix  = tniEmployeeData.map(item => item.incorrect_answers);
    
            var TNIEMPMatrixChartOptions = {
                chart: { type: 'bar', height: 400, toolbar: { show: false } },
                series: [
                    { name: 'Total Questions', data: totalQuestionsTNIempMatrix  },
                    { name: 'Correct Answers', data: correctAnswersTNIempMatrix  },
                    { name: 'Incorrect Answers', data: incorrectAnswersTNIempMatrix  }
                ],
                xaxis: { categories: categoriesTNIempMatrix  },
                title: { text: 'TNI Employee Training Results', align: 'center' },
                plotOptions: { bar: { horizontal: false, columnWidth: '50%' } }
            };
    
            var TNIEMPMatrixChart = new ApexCharts(document.querySelector("#TNIEMPMatrixChart"), TNIEMPMatrixChartOptions);
            TNIEMPMatrixChart.render();
        @endif

        @if ($hasdeparmentWiseTrainingData)
            const deparmentWiseData = @json($deparmentWiseTraining);
            console.log(deparmentWiseData); // Optional: logs data to the browser console for further inspection.
    
            const categoriesdeparmentWise = deparmentWiseData.map(item => `Training ID: ${item.training_id}`);
            const totalQuestionsdeparmentWise  = deparmentWiseData.map(item => item.total_questions);
            const correctAnswersdeparmentWise  = deparmentWiseData.map(item => item.correct_answers);
            const incorrectAnswersdeparmentWise  = deparmentWiseData.map(item => item.incorrect_answers);
    
            var deparmentWiseChartOptions = {
                chart: { type: 'bar', height: 400, toolbar: { show: false } },
                series: [
                    { name: 'Total Questions', data: totalQuestionsdeparmentWise  },
                    { name: 'Correct Answers', data: correctAnswersdeparmentWise  },
                    { name: 'Incorrect Answers', data: incorrectAnswersdeparmentWise  }
                ],
                xaxis: { categories: categoriesdeparmentWise  },
                title: { text: 'TNI Employee Training Results', align: 'center' },
                plotOptions: { bar: { horizontal: false, columnWidth: '50%' } }
            };
    
            var deparmentWiseChart = new ApexCharts(document.querySelector("#deparmentWiseChart"), deparmentWiseChartOptions);
            deparmentWiseChart.render();
        @endif
        
        @if ($hasInductionData)
            const inductionData = @json($inductionTraining);
            const categoriesInduction = inductionData.map(item => `Training ID: ${item.training_id}`);
            const totalQuestionsInduction = inductionData.map(item => item.total_questions);
            const correctAnswersInduction = inductionData.map(item => item.correct_answers);
            const incorrectAnswersInduction = inductionData.map(item => item.incorrect_answers);

            var inductionChartOptions = {
                chart: { type: 'bar', height: 400, toolbar: { show: false } },
                series: [
                    { name: 'Total Questions', data: totalQuestionsInduction },
                    { name: 'Correct Answers', data: correctAnswersInduction },
                    { name: 'Incorrect Answers', data: incorrectAnswersInduction }
                ],
                xaxis: { categories: categoriesInduction },
                title: { text: 'Induction Training Results', align: 'center' },
                plotOptions: { bar: { horizontal: false, columnWidth: '50%' } }
            };

            var inductionChart = new ApexCharts(document.querySelector("#inductionChart"), inductionChartOptions);
            inductionChart.render();
        @endif

        @if ($hasOnJobData)
            const onJobData = @json($onJobTraining);
            const categoriesOnJob = onJobData.map(item => `Training ID: ${item.training_id}`);
            const totalQuestionsOnJob = onJobData.map(item => item.total_questions);
            const correctAnswersOnJob = onJobData.map(item => item.correct_answers);
            const incorrectAnswersOnJob = onJobData.map(item => item.incorrect_answers);

            var onJobChartOptions = {
                chart: { type: 'bar', height: 400, toolbar: { show: false } },
                series: [
                    { name: 'Total Questions', data: totalQuestionsOnJob },
                    { name: 'Correct Answers', data: correctAnswersOnJob },
                    { name: 'Incorrect Answers', data: incorrectAnswersOnJob }
                ],
                xaxis: { categories: categoriesOnJob },
                title: { text: 'On The Job Training Results', align: 'center' },
                plotOptions: { bar: { horizontal: false, columnWidth: '50%' } }
            };

            var onJobChart = new ApexCharts(document.querySelector("#onJobChart"), onJobChartOptions);
            onJobChart.render();
        @endif

        @if ($hasClassroomData)
            const classroomData = @json($classroomTraining);
            const categoriesClassroom = classroomData.map(item => `Training ID: ${item.training_id}`);
            const totalQuestionsClassroom = classroomData.map(item => item.total_questions);
            const correctAnswersClassroom = classroomData.map(item => item.correct_answers);
            const incorrectAnswersClassroom = classroomData.map(item => item.incorrect_answers);

            var classroomChartOptions = {
                chart: { type: 'bar', height: 400, toolbar: { show: false } },
                series: [
                    { name: 'Total Questions', data: totalQuestionsClassroom },
                    { name: 'Correct Answers', data: correctAnswersClassroom },
                    { name: 'Incorrect Answers', data: incorrectAnswersClassroom }
                ],
                xaxis: { categories: categoriesClassroom },
                title: { text: 'Classroom Training Results', align: 'center' },
                plotOptions: { bar: { horizontal: false, columnWidth: '50%' } }
            };

            var classroomChart = new ApexCharts(document.querySelector("#classroomChart"), classroomChartOptions);
            classroomChart.render();
        @endif

        
    </script>
</body>

</html>
