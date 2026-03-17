<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }}</title>

    <link rel="stylesheet" href="{{ base_path('public/css/bootstrap_trimmed.min.css') }}" />

    <style>
        body {
            background-color: #f3f4f6;
            font-family:
                ui-sans-serif,
                system-ui,
                -apple-system,
                BlinkMacSystemFont,
                "Segoe UI",
                Roboto,
                "Helvetica Neue",
                Arial,
                "Noto Sans",
                sans-serif;
            margin: 0;
            padding: 0;
            color: #374151;
        }

        .container {
            max-width: 1200px;
            margin: auto;
            padding: 1.5rem;
        }

        .card {
            background-color: #ffffff;
            padding: 1.5rem;
            border-radius: 0.5rem;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
            margin-bottom: 2rem;
        }

        h2.section-title {
            border-left: 4px solid #fbbf24;
            padding-left: 1rem;
            color: #fbbf24;
            font-size: 1.5rem;
            font-weight: 700;
            margin: 0 0 1rem 0;
        }

        h3.sub-title {
            font-size: 0.75rem;
            color: #6b7280;
            font-weight: 600;
            text-transform: uppercase;
            margin: 0 0 0.25rem 0;
        }

        .profile-header {
            display: flex;
            flex-wrap: wrap;
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .profile-header img {
            width: 9rem;
            height: 9rem;
            object-fit: cover;
            border-radius: 0.5rem;
            flex-shrink: 0;
        }

        .profile-info {
            flex: 1;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .info-block h5 {
            margin: 0;
        }

        .section-content {
            display: flex;
            flex-wrap: wrap;
            gap: 3rem;
            margin-top: 1rem;
        }

        .section-content>div {
            flex: 1;
            min-width: 250px;
        }

        .vitals {
            display: flex;
            flex-wrap: wrap;
            gap: 2rem;
            justify-content: space-evenly;
            text-align: center;
        }

        .vital-item h1 {
            font-size: 1.25rem;
            font-weight: 700;
            margin: 0.25rem 0;
        }

        .vital-item p {
            font-size: 0.625rem;
            color: #6b7280;
            margin: 0;
        }

        @media (max-width: 768px) {
            .profile-info {
                grid-template-columns: 1fr;
            }

            .section-content {
                flex-direction: column;
            }

            .vitals {
                flex-direction: column;
                gap: 1rem;
            }
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="card">
            <!-- Profile Header -->
            <section class="profile-header">
                <img src="https://tse4.mm.bing.net/th/id/OIP.rWR-uAUTI2Es1uZKtvMgmQHaE8?rs=1&pid=ImgDetMain&o=7&rm=3"
                    alt="Patient Image" />
                <div class="profile-info">
                    <div class="info-block">
                        <h2 class="section-title">Patient Profile</h2>
                        <div>
                            <h3 class="sub-title">Full Name</h3>
                            <h5>Jonathan Doe Richardson</h5>
                        </div>
                        <div>
                            <h3 class="sub-title">ID / National Insurance Number</h3>
                            <h5>JP-9882-1200-XX</h5>
                        </div>
                    </div>
                    <div class="info-block">
                        <div>
                            <h3 class="sub-title">Date of Birth</h3>
                            <h5>May 14, 1985 (38y)</h5>
                        </div>
                        <div>
                            <h3 class="sub-title">Gender</h3>
                            <h5>Male</h5>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Contact & Emergency -->
            <section class="section-content">
                <div>
                    <h2 class="section-title">Contact Information</h2>
                    <div>
                        <h3 class="sub-title">Residential Address</h3>
                        <h5>4521 Oakwood Avenue, Apt 4B, Seattle, WA 98101</h5>
                    </div>
                    <div>
                        <h3 class="sub-title">Phone Number</h3>
                        <h5>(555) 234-5678</h5>
                    </div>
                    <div>
                        <h3 class="sub-title">Email</h3>
                        <h5>j.richardson@email.com</h5>
                    </div>
                </div>

                <div>
                    <h2 class="section-title">Emergency Contact</h2>
                    <div>
                        <h3 class="sub-title">Name</h3>
                        <h5>Sarah Richardson</h5>
                    </div>
                    <div>
                        <h3 class="sub-title">Relationship</h3>
                        <h5>Spouse</h5>
                    </div>
                    <div>
                        <h3 class="sub-title">Contact</h3>
                        <h5>(555) 987-643</h5>
                    </div>
                </div>
            </section>

            <!-- Vitals -->
            <section style="margin-top: 2rem">
                <h2 class="section-title">
                    Recent Vitals (Last Recorded: Oct 20, 2023)
                </h2>
                <div class="vitals">
                    <div class="vital-item">
                        <h3 class="sub-title">Blood Pressure</h3>
                        <h1>128/82</h1>
                        <p>mmHg</p>
                    </div>
                    <div class="vital-item">
                        <h3 class="sub-title">Heart Rate</h3>
                        <h1>74</h1>
                        <p>bpm</p>
                    </div>
                    <div class="vital-item">
                        <h3 class="sub-title">Temperature</h3>
                        <h1>98.6</h1>
                        <p>°F</p>
                    </div>
                    <div class="vital-item">
                        <h3 class="sub-title">O₂ Saturation</h3>
                        <h1>97</h1>
                        <p>%</p>
                    </div>
                </div>
            </section>

            <!-- Insurance -->
            <section style="margin-top: 2rem">
                <h2 class="section-title">Insurance Information</h2>
                <div class="section-content">
                    <div>
                        <h3 class="sub-title">Provider</h3>
                        <h5>Blue Shield Comprehensive</h5>
                    </div>
                    <div>
                        <h3 class="sub-title">Policy Number</h3>
                        <h5>BS-778899X1</h5>
                    </div>
                    <div>
                        <h3 class="sub-title">Group ID</h3>
                        <h5>GRP-4022</h5>
                    </div>
                </div>
            </section>
        </div>
    </div>

</body>

</html>
