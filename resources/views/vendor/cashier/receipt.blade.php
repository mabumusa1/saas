<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- begin::Fonts --}}
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    {{-- end::Fonts --}}
    <link href="{{ asset('skin/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    <title>Invoice</title>

    <style>
        .table {
            width: 100%;
        }

        .py-20 {
            padding-top: 5rem !important;
            padding-bottom: 5rem !important;
        }

        body {
            background: #fff none;
            font-family: DejaVu Sans, 'sans-serif';
            font-size: 12px;
        }

        h2 {
            font-size: 28px;
            color: #ccc;
        }

        .container {
            padding-top: 30px;
        }

        .invoice-head td {
            padding: 0 8px;
        }

        .border-0 {
            border: 0;
        }

        .table th {
            vertical-align: bottom;
            font-weight: bold;
            padding: 8px;
            line-height: 14px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .table tr.row td {
            border-bottom: 1px solid #ddd;
        }

        .table td {
            padding: 8px;
            line-height: 14px;
            text-align: left;
            vertical-align: top;
        }

        html,
        body {
            width: 100%;
            height: 100%;

        }

        .fw-boldest {
            font-weight: 700 !important;
        }

        .text-gray-800 {
            color: #3f4254 !important;
        }

        .fs-2qx {
            font-size: 25px !important;
        }

        .fs-2 {
            font-size: 24px !important;
        }

        .fs-5 {
            font-size: 18.4px !important;
        }

        .fs-6 {
            font-size: 17.2px !important;
        }

        .fw-bolder {
            font-weight: 600 !important;
        }

        .text-muted {
            color: #a1a5b7 !important;
        }

        .separator {
            display: block;
            height: 0;
            border-bottom: 1px solid #eff2f5;
            margin-top: 40px;
            margin-bottom: 40px;
        }

        .gap {
            margin-top: 40px;
            margin-bottom: 40px;
        }

        .text-end{
            text-align: right;
        }
    </style>
</head>

<body>
    <!-- begin::Header-->
    <table style="width: 100%">
        <!--begin::Logo-->
        <tr style="width: 100%">
            <td style="width: 70%">
                <h4 class="fw-boldest text-gray-800 fs-2qx pe-5 pb-7">INVOICE</h4>
            </td>
            <td style="width: 30%;text-align: right">
                <img alt="Logo" width="150"
                    src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4KPCEtLSBHZW5lcmF0b3I6IEFkb2JlIElsbHVzdHJhdG9yIDIyLjEuMCwgU1ZHIEV4cG9ydCBQbHVnLUluIC4gU1ZHIFZlcnNpb246IDYuMDAgQnVpbGQgMCkgIC0tPgo8c3ZnIHZlcnNpb249IjEuMSIKCSBpZD0ic3ZnNDEzIiBpbmtzY2FwZTpleHBvcnQtZmlsZW5hbWU9Ii9ob21lL3VzZXIvRGVza3RvcC9TdGVlciBDYW1wYWlnbiBCcmFuZGluZy9sb2dvLWNvbG9yLnBuZyIgaW5rc2NhcGU6ZXhwb3J0LXhkcGk9Ijk2IiBpbmtzY2FwZTpleHBvcnQteWRwaT0iOTYiIGlua3NjYXBlOnZlcnNpb249IjEuMSAoMToxLjErMjAyMTA1MjYxNTE3K2NlNjY2M2IzYjcpIiBzb2RpcG9kaTpkb2NuYW1lPSJsb2dvLWNvbG9yLnN2ZyIgeG1sbnM6aW5rc2NhcGU9Imh0dHA6Ly93d3cuaW5rc2NhcGUub3JnL25hbWVzcGFjZXMvaW5rc2NhcGUiIHhtbG5zOnNvZGlwb2RpPSJodHRwOi8vc29kaXBvZGkuc291cmNlZm9yZ2UubmV0L0RURC9zb2RpcG9kaS0wLmR0ZCIgeG1sbnM6c3ZnPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIKCSB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiB4PSIwcHgiIHk9IjBweCIgdmlld0JveD0iMCAwIDEyMDAgNzI4IgoJIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDEyMDAgNzI4OyIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSI+CjxzdHlsZSB0eXBlPSJ0ZXh0L2NzcyI+Cgkuc3Qwe2VuYWJsZS1iYWNrZ3JvdW5kOm5ldyAgICA7fQoJLnN0MXtmaWxsOiM0MTcwQkQ7fQo8L3N0eWxlPgo8c29kaXBvZGk6bmFtZWR2aWV3ICBib3JkZXJjb2xvcj0iIzY2NjY2NiIgYm9yZGVyb3BhY2l0eT0iMS4wIiBpZD0ibmFtZWR2aWV3NDE1IiBpbmtzY2FwZTpjdXJyZW50LWxheWVyPSJsYXllcjIiIGlua3NjYXBlOmN4PSI2MzUiIGlua3NjYXBlOmN5PSIyNzEiIGlua3NjYXBlOmRvY3VtZW50LXVuaXRzPSJweCIgaW5rc2NhcGU6cGFnZWNoZWNrZXJib2FyZD0iMCIgaW5rc2NhcGU6cGFnZW9wYWNpdHk9IjEiIGlua3NjYXBlOnBhZ2VzaGFkb3c9IjIiIGlua3NjYXBlOndpbmRvdy1oZWlnaHQ9IjgzNiIgaW5rc2NhcGU6d2luZG93LW1heGltaXplZD0iMSIgaW5rc2NhcGU6d2luZG93LXdpZHRoPSIxNTI4IiBpbmtzY2FwZTp3aW5kb3cteD0iNzIiIGlua3NjYXBlOndpbmRvdy15PSIyNyIgaW5rc2NhcGU6em9vbT0iMC41IiBwYWdlY29sb3I9IiNmM2Y2ZmUiIHNob3dncmlkPSJmYWxzZSIgdW5pdHM9InB4IiB3aWR0aD0iMzUwcHgiPgoJPC9zb2RpcG9kaTpuYW1lZHZpZXc+CjxnIGlkPSJsYXllcjEiIGlua3NjYXBlOmdyb3VwbW9kZT0ibGF5ZXIiIGlua3NjYXBlOmxhYmVsPSJCYWNrZ3JvdW5kIj4KPC9nPgo8ZyBpZD0ibGF5ZXIyIiBpbmtzY2FwZTpncm91cG1vZGU9ImxheWVyIiBpbmtzY2FwZTpsYWJlbD0iU2xvZ2FuIj4KCTxnIGNsYXNzPSJzdDAiPgoJCTxwYXRoIGNsYXNzPSJzdDEiIGQ9Ik02MjkuMSwzNTguNWg1Ljd2MjcuOWgtMy42di0yNC4xSDYzMWwtOS44LDI0LjFoLTMuOGwtOS45LTI0LjFoMHYyNC4xaC0zLjZ2LTI3LjloNS43bDkuNywyMy45aDAuMQoJCQlMNjI5LjEsMzU4LjV6Ii8+CgkJPHBhdGggY2xhc3M9InN0MSIgZD0iTTY0Mi4yLDM2Ny4yYzIuMy0xLDQuOC0xLjUsNy41LTEuNWMyLjcsMCw0LjcsMC44LDYuMSwyLjNzMi4xLDMuNCwyLjEsNS42djEyLjloLTMuMmwtMC40LTIuNmgtMC4xCgkJCWMtMS45LDItNC40LDMtNy40LDNjLTEuOCwwLTMuNC0wLjUtNC42LTEuNmMtMS4zLTEuMS0xLjktMi42LTEuOS00LjVzMC44LTMuNCwyLjMtNC42czMuOC0xLjgsNi45LTEuOGg0Ljh2LTAuMwoJCQljMC0xLjgtMC40LTMtMS4zLTMuOGMtMC45LTAuOC0yLjQtMS4yLTQuNS0xLjJjLTIuMSwwLTQuMSwwLjUtNiwxLjRoLTAuMlYzNjcuMnogTTY1NC4yLDM4MC43di0zLjRoLTQuNGMtNCwwLTYsMS4xLTYsMy4yCgkJCXMxLjQsMy4yLDQuMiwzLjJjMS4yLDAsMi4zLTAuMywzLjQtMC45QzY1Mi41LDM4Mi4yLDY1My41LDM4MS41LDY1NC4yLDM4MC43eiIvPgoJCTxwYXRoIGNsYXNzPSJzdDEiIGQ9Ik02NzUuMiwzNjUuN2gwLjN2My41aC0wLjNjLTEuNiwwLTMsMC4zLTQuNCwwLjlzLTIuNCwxLjUtMy4yLDIuNnYxMy44SDY2NHYtMjAuNGgzLjJsMC40LDIuNnYwLjZoMC4xCgkJCUM2NjkuNiwzNjYuOSw2NzIuMSwzNjUuNyw2NzUuMiwzNjUuN3oiLz4KCQk8cGF0aCBjbGFzcz0ic3QxIiBkPSJNNjg4LjcsMzc0LjNsOS4yLDEyLjJoLTQuNWwtNy4yLTkuNmgtMC4xbC0zLDN2Ni43aC0zLjZ2LTI5LjJoMy42djE3LjloMC4xbDguOC05LjFoNC45TDY4OC43LDM3NC4zeiIvPgoJCTxwYXRoIGNsYXNzPSJzdDEiIGQ9Ik03MTkuMiwzNzYuM3YxLjNoLTE1LjRjMC4yLDEuOSwwLjksMy4zLDIuMSw0LjRjMS4yLDEsMywxLjYsNS4zLDEuNmMyLjQsMCw0LjYtMC43LDYuNi0yaDAuMnYzLjUKCQkJYy0yLjIsMS4zLTQuOSwxLjktNy45LDEuOWMtMywwLTUuNS0wLjktNy4zLTIuOGMtMS44LTEuOS0yLjctNC40LTIuNy03LjVzMC44LTUuOCwyLjQtNy44YzEuNi0yLjEsNC0zLjEsNy4xLTMuMQoJCQljMy4xLDAsNS41LDEsNy4xLDMuMUM3MTguNCwzNzAuOCw3MTkuMiwzNzMuMyw3MTkuMiwzNzYuM3ogTTcwMy44LDM3NC42aDExLjhjLTAuMS0xLjktMC44LTMuNC0xLjktNC40Yy0xLjItMS0yLjUtMS41LTQtMS41CgkJCXMtMi44LDAuNS00LDEuNUM3MDQuNSwzNzEuMiw3MDMuOSwzNzIuNyw3MDMuOCwzNzQuNnoiLz4KCQk8cGF0aCBjbGFzcz0ic3QxIiBkPSJNNzM0LjksMzY5LjJoLTUuOHYxMi4xYzAsMS4xLDAuMywxLjgsMC45LDIuMWMwLjUsMC4yLDEuMiwwLjMsMiwwLjNzMS43LTAuMiwyLjYtMC42aDAuM3YzCgkJCWMtMS4xLDAuNi0yLjMsMC45LTMuNiwwLjljLTMuOSwwLTUuOC0xLjgtNS44LTUuM3YtMTIuNGgtMy44di0wLjJsNy40LTcuM3Y0LjRoNS44VjM2OS4yeiIvPgoJCTxwYXRoIGNsYXNzPSJzdDEiIGQ9Ik03NDMuNCwzNTcuOHYzLjloLTMuOXYtMy45SDc0My40eiBNNzM5LjYsMzg2LjV2LTIwLjRoMy42djIwLjRINzM5LjZ6Ii8+CgkJPHBhdGggY2xhc3M9InN0MSIgZD0iTTc2MC44LDM2NS43YzIuMiwwLDQsMC43LDUuMiwyLjJjMS4zLDEuNSwxLjksMy40LDEuOSw1LjZ2MTNoLTMuNnYtMTIuNmMwLTMuMy0xLjUtNC45LTQuNC00LjkKCQkJYy0yLjMsMC00LjUsMS4zLTYuNiwzLjh2MTMuNmgtMy42di0yMC40aDMuMmwwLjQsMi42djAuNmgwLjFDNzU1LjYsMzY2LjksNzU4LjEsMzY1LjcsNzYwLjgsMzY1Ljd6Ii8+CgkJPHBhdGggY2xhc3M9InN0MSIgZD0iTTc4OS44LDM2Ni4xaDMuMnYxOS41YzAsMy40LTAuOCw1LjktMi40LDcuOGMtMS42LDEuOC00LDIuNy03LjEsMi43cy01LjktMC43LTguNC0ydi0zLjZoMC4yCgkJCWMyLjMsMS41LDQuOSwyLjIsOCwyLjJjNC4xLDAsNi4xLTIuMiw2LjEtNi41di0yLjZoLTAuMWMtMS44LDItNCwzLTYuNiwzYy0yLjYsMC00LjgtMC45LTYuOC0yLjdjLTItMS44LTMtNC40LTMtNy43CgkJCWMwLTMuMywxLTUuOCwzLTcuN2MyLTEuOCw0LjMtMi43LDYuOC0yLjdjMi42LDAsNC44LDEsNi42LDNoMC4xTDc4OS44LDM2Ni4xeiBNNzg5LjQsMzgwLjJ2LTguMmMtMS45LTItMy45LTMtNi0zcy0zLjcsMC42LTUsMS44CgkJCWMtMS4zLDEuMi0xLjksMy0xLjksNS4zczAuNiw0LDEuOSw1LjNjMS4zLDEuMiwyLjksMS44LDUsMS44Uzc4Ny41LDM4Mi4yLDc4OS40LDM4MC4yeiIvPgoJCTxwYXRoIGNsYXNzPSJzdDEiIGQ9Ik04MzAuMywzODYuNWwtMy03LjJoLTEzLjZsLTMsNy4yaC00bDExLjgtMjcuOWgzLjhsMTEuOCwyNy45SDgzMC4zeiBNODE1LjIsMzc1Ljh2MC4yaDEwLjd2LTAuMmwtNS4zLTEyLjgKCQkJaC0wLjFMODE1LjIsMzc1Ljh6Ii8+CgkJPHBhdGggY2xhc3M9InN0MSIgZD0iTTg0NC42LDM4Ni45Yy0yLjIsMC00LTAuNy01LjItMi4yYy0xLjMtMS41LTEuOS0zLjQtMS45LTUuNnYtMTNoMy42djEyLjZjMCwzLjMsMS41LDQuOSw0LjQsNC45CgkJCWMyLjMsMCw0LjUtMS4zLDYuNi0zLjh2LTEzLjZoMy42djIwLjRoLTMuMmwtMC40LTIuNnYtMC42SDg1MkM4NDkuOCwzODUuNyw4NDcuNCwzODYuOSw4NDQuNiwzODYuOXoiLz4KCQk8cGF0aCBjbGFzcz0ic3QxIiBkPSJNODcyLjgsMzY5LjJIODY3djEyLjFjMCwxLjEsMC4zLDEuOCwwLjksMi4xYzAuNSwwLjIsMS4yLDAuMywyLDAuM3MxLjctMC4yLDIuNi0wLjZoMC4zdjMKCQkJYy0xLjEsMC42LTIuMywwLjktMy42LDAuOWMtMy45LDAtNS44LTEuOC01LjgtNS4zdi0xMi40aC0zLjh2LTAuMmw3LjQtNy4zdjQuNGg1LjhWMzY5LjJ6Ii8+CgkJPHBhdGggY2xhc3M9InN0MSIgZD0iTTg3Ni4yLDM3Ni4zYzAtMy4yLDAuOS01LjcsMi44LTcuN2MxLjktMS45LDQuMy0yLjksNy40LTIuOWMzLjEsMCw1LjYsMSw3LjQsMi45YzEuOSwxLjksMi44LDQuNSwyLjgsNy43CgkJCWMwLDMuMi0wLjksNS43LTIuOCw3LjdjLTEuOSwxLjktNC40LDIuOS03LjQsMi45Yy0zLjEsMC01LjYtMS03LjQtMi45Qzg3Ny4xLDM4Miw4NzYuMiwzNzkuNCw4NzYuMiwzNzYuM3ogTTg4MS44LDM4MS43CgkJCWMxLjMsMS4yLDIuOSwxLjgsNC42LDEuOHMzLjMtMC42LDQuNi0xLjhjMS4zLTEuMiwyLTMsMi01LjVzLTAuNy00LjMtMi01LjVjLTEuMy0xLjItMi45LTEuOC00LjYtMS44cy0zLjMsMC42LTQuNiwxLjgKCQkJcy0yLDMtMiw1LjVTODgwLjUsMzgwLjUsODgxLjgsMzgxLjd6Ii8+CgkJPHBhdGggY2xhc3M9InN0MSIgZD0iTTkyNS42LDM2NS43YzIuMiwwLDMuOCwwLjgsNSwyLjNzMS43LDMuMywxLjcsNS40djEzLjFoLTMuNnYtMTIuNGMwLTEuNy0wLjMtMy0wLjktMy44cy0xLjctMS4yLTMuMS0xLjIKCQkJYy0yLjMsMC00LjIsMS4zLTUuOCwzLjh2MTMuNmgtMy42di0xMi40YzAtMS43LTAuMy0zLTAuOS0zLjhzLTEuNy0xLjItMy4yLTEuMmMtMi4zLDAtNC4yLDEuMy01LjgsMy44djEzLjZoLTMuNnYtMjAuNGgzLjIKCQkJbDAuNCwyLjZ2MC42aDAuMWMxLjctMi40LDMuOS0zLjYsNi43LTMuNmMxLjUsMCwyLjgsMC40LDMuOCwxLjJzMS44LDEuNywyLjMsMi45aDAuMUM5MjAsMzY3LDkyMi40LDM2NS43LDkyNS42LDM2NS43eiIvPgoJCTxwYXRoIGNsYXNzPSJzdDEiIGQ9Ik05MzguOCwzNjcuMmMyLjMtMSw0LjgtMS41LDcuNS0xLjVjMi43LDAsNC43LDAuOCw2LjEsMi4zYzEuNCwxLjUsMi4xLDMuNCwyLjEsNS42djEyLjloLTMuMmwtMC40LTIuNmgtMC4xCgkJCWMtMS45LDItNC40LDMtNy40LDNjLTEuOCwwLTMuNC0wLjUtNC42LTEuNmMtMS4zLTEuMS0xLjktMi42LTEuOS00LjVzMC44LTMuNCwyLjMtNC42YzEuNi0xLjIsMy44LTEuOCw2LjktMS44aDQuOHYtMC4zCgkJCWMwLTEuOC0wLjQtMy0xLjMtMy44cy0yLjQtMS4yLTQuNS0xLjJzLTQuMSwwLjUtNiwxLjRoLTAuMlYzNjcuMnogTTk1MC45LDM4MC43di0zLjRoLTQuNGMtNCwwLTYsMS4xLTYsMy4yczEuNCwzLjIsNC4yLDMuMgoJCQljMS4yLDAsMi4zLTAuMywzLjQtMC45Qzk0OS4yLDM4Mi4yLDk1MC4xLDM4MS41LDk1MC45LDM4MC43eiIvPgoJCTxwYXRoIGNsYXNzPSJzdDEiIGQ9Ik05NzEuNCwzNjkuMmgtNS44djEyLjFjMCwxLjEsMC4zLDEuOCwwLjksMi4xYzAuNSwwLjIsMS4yLDAuMywyLDAuM3MxLjctMC4yLDIuNi0wLjZoMC4zdjMKCQkJYy0xLjEsMC42LTIuMywwLjktMy42LDAuOWMtMy45LDAtNS44LTEuOC01LjgtNS4zdi0xMi40aC0zLjh2LTAuMmw3LjQtNy4zdjQuNGg1LjhWMzY5LjJ6Ii8+CgkJPHBhdGggY2xhc3M9InN0MSIgZD0iTTk4MCwzNTcuOHYzLjloLTMuOXYtMy45SDk4MHogTTk3Ni4yLDM4Ni41di0yMC40aDMuNnYyMC40SDk3Ni4yeiIvPgoJCTxwYXRoIGNsYXNzPSJzdDEiIGQ9Ik05ODUuMSwzNzYuM2MwLTMuMiwwLjktNS43LDIuOC03LjdjMS45LTEuOSw0LjMtMi45LDcuNC0yLjljMy4xLDAsNS42LDEsNy40LDIuOWMxLjksMS45LDIuOCw0LjUsMi44LDcuNwoJCQljMCwzLjItMC45LDUuNy0yLjgsNy43Yy0xLjksMS45LTQuNCwyLjktNy40LDIuOWMtMy4xLDAtNS42LTEtNy40LTIuOUM5ODYsMzgyLDk4NS4xLDM3OS40LDk4NS4xLDM3Ni4zeiBNOTkwLjcsMzgxLjcKCQkJYzEuMywxLjIsMi45LDEuOCw0LjYsMS44YzEuOCwwLDMuMy0wLjYsNC42LTEuOGMxLjMtMS4yLDItMywyLTUuNXMtMC43LTQuMy0yLTUuNXMtMi45LTEuOC00LjYtMS44Yy0xLjgsMC0zLjMsMC42LTQuNiwxLjgKCQkJYy0xLjMsMS4yLTIsMy0yLDUuNVM5ODkuNCwzODAuNSw5OTAuNywzODEuN3oiLz4KCQk8cGF0aCBjbGFzcz0ic3QxIiBkPSJNMTAyMS43LDM2NS43YzIuMiwwLDQsMC43LDUuMiwyLjJzMS45LDMuNCwxLjksNS42djEzaC0zLjZ2LTEyLjZjMC0zLjMtMS41LTQuOS00LjQtNC45CgkJCWMtMi4zLDAtNC41LDEuMy02LjYsMy44djEzLjZoLTMuNnYtMjAuNGgzLjJsMC40LDIuNnYwLjZoMC4xQzEwMTYuNSwzNjYuOSwxMDE5LDM2NS43LDEwMjEuNywzNjUuN3oiLz4KCTwvZz4KPC9nPgo8ZyBpZD0ibGF5ZXI0IiBpbmtzY2FwZTpncm91cG1vZGU9ImxheWVyIiBpbmtzY2FwZTpsYWJlbD0iSWNvbiI+Cgk8ZyBpZD0iZzY4MiIgdHJhbnNmb3JtPSJtYXRyaXgoMC40ODQyOTg4MSwwLDAsMC40ODQyOTg4MSwtMTMuMTEzODEzLDIzLjY2MzUxKSI+CgkJPHBhdGggaWQ9InBhdGg2NzQiIGNsYXNzPSJzdDEiIGQ9Ik00MDAuMiw1ODIuOGMzMy40LDAsNjAuNS0yNy4xLDYwLjUtNjAuNXMtMjcuMS02MC41LTYwLjUtNjAuNXMtNjAuNSwyNy4xLTYwLjUsNjAuNQoJCQlTMzY2LjgsNTgyLjgsNDAwLjIsNTgyLjh6IE00MDAuMiw0OTIuMWMxNi43LDAsMzAuMiwxMy42LDMwLjIsMzAuMmMwLDE2LjctMTMuNiwzMC4yLTMwLjIsMzAuMnMtMzAuMi0xMy42LTMwLjItMzAuMgoJCQlDMzY5LjksNTA1LjcsMzgzLjUsNDkyLjEsNDAwLjIsNDkyLjF6Ii8+CgkJPHBhdGggaWQ9InBhdGg2NzYiIGNsYXNzPSJzdDEiIGQ9Ik00NjguMiwzOTUuOWM5LjUsMCwxNy4xLTcuNywxNy4xLTE3LjFjMC05LjUtNy43LTE3LjEtMTcuMS0xNy4xYy05LjUsMC0xNy4xLDcuNy0xNy4xLDE3LjEKCQkJQzQ1MS4xLDM4OC4yLDQ1OC44LDM5NS45LDQ2OC4yLDM5NS45eiIvPgoJCTxwYXRoIGlkPSJwYXRoNjc4IiBjbGFzcz0ic3QxIiBkPSJNMTk2LjEsNTg4LjRjLTkuNSwwLTE3LjEsNy43LTE3LjEsMTcuMWMwLDkuNSw3LjcsMTcuMSwxNy4xLDE3LjFzMTcuMS03LjcsMTcuMS0xNy4xCgkJCUMyMTMuMiw1OTYsMjA1LjUsNTg4LjQsMTk2LjEsNTg4LjR6Ii8+CgkJPHBhdGggaWQ9InBhdGg2ODAiIGNsYXNzPSJzdDEiIGQ9Ik05ODkuOCwzNDAuOUg3OTAuNWMtOTguNSwwLTE3OC43LDgwLjItMTc4LjcsMTc4Ljd2MTg0LjFINDI3LjdjLTk4LjUsMC0xNzguNyw4MC4yLTE3OC43LDE3OC43CgkJCXYxOTkuM2MwLDguNCw2LjgsMTUuMSwxNS4xLDE1LjFoMTk5LjNjOTguNSwwLDE3OC43LTgwLjIsMTc4LjctMTc4LjdWNzM0aDE4NC4xYzk4LjUsMCwxNzguNy04MC4yLDE3OC43LTE3OC43VjM1Ni4xCgkJCUMxMDA0LjksMzQ3LjcsOTk4LjEsMzQwLjksOTg5LjgsMzQwLjlMOTg5LjgsMzQwLjl6IE02MTEuOCw5MTguMWMwLDgxLjktNjYuNiwxNDguNS0xNDguNSwxNDguNUgyNzkuMlY4ODIuNQoJCQljMC04MS45LDY2LjYtMTQ4LjUsMTQ4LjUtMTQ4LjVoMTg0LjFWOTE4LjF6IE05NzQuNyw1NTUuM2MwLDgxLjktNjYuNiwxNDguNS0xNDguNSwxNDguNUg2NDIuMVY1MTkuNgoJCQljMC04MS45LDY2LjYtMTQ4LjUsMTQ4LjUtMTQ4LjVoMTg0LjFMOTc0LjcsNTU1LjN6Ii8+Cgk8L2c+CjwvZz4KPGcgY2xhc3M9InN0MCI+Cgk8cGF0aCBjbGFzcz0ic3QxIiBkPSJNNDk5LjMsMjg0LjVjMCwyLjEsMC45LDMuOSwyLjcsNS4zYzEuOCwxLjQsNCwyLjUsNi42LDMuMmMyLjYsMC44LDUuNCwxLjYsOC42LDIuNWMzLjEsMC45LDYsMS44LDguNywyLjYKCQljMi43LDAuOCw0LjksMi40LDYuNiw0LjhjMS43LDIuNCwyLjYsNS40LDIuNiw5YzAsNC44LTIsOC44LTUuOSwxMS44Yy00LDMuMS05LjUsNC42LTE2LjYsNC42Yy03LjEsMC0xMy44LTEuNS0yMC4yLTQuNnYtNy41aDAuNAoJCWM1LjgsMy4zLDEyLjUsNC45LDIwLDQuOWM5LjgsMCwxNC44LTMuMywxNC44LTkuOGMwLTMuMi0yLjQtNS41LTcuMi03Yy0yLTAuNi00LjMtMS4zLTYuOS0yYy0yLjUtMC43LTUuMS0xLjUtNy42LTIuMwoJCXMtNC45LTEuNy03LTIuOWMtMi4xLTEuMi0zLjgtMi44LTUuMS00LjhjLTEuMy0yLjEtMi00LjUtMi03LjNjMC00LjksMS45LTksNS44LTEyLjNjMy44LTMuMyw5LTUsMTUuNi01YzYuNSwwLDEyLjUsMSwxNy43LDN2Ny4yCgkJaC0wLjZjLTUuMy0yLjEtMTAuNC0zLjItMTUuMi0zLjJjLTQuOSwwLTguNywwLjktMTEuNSwyLjZDNTAwLjgsMjc5LjEsNDk5LjMsMjgxLjUsNDk5LjMsMjg0LjV6Ii8+Cgk8cGF0aCBjbGFzcz0ic3QxIiBkPSJNNTY4LjEsMjkxLjFoLTEyLjJ2MjUuNWMwLDIuNCwwLjYsMy44LDEuOSw0LjRjMS4xLDAuNSwyLjQsMC43LDQuMSwwLjdjMS43LDAsMy41LTAuNCw1LjYtMS4zaDAuNnY2LjIKCQljLTIuNCwxLjItNC45LDEuOS03LjYsMS45Yy04LjIsMC0xMi4zLTMuNy0xMi4zLTExLjF2LTI2LjFoLTh2LTAuNWwxNS43LTE1LjN2OS4zaDEyLjJWMjkxLjF6Ii8+Cgk8cGF0aCBjbGFzcz0ic3QxIiBkPSJNNjE1LjYsMzA2djIuN0g1ODNjMC40LDMuOSwxLjksNyw0LjQsOS4yYzIuNSwyLjIsNi4yLDMuMywxMS4zLDMuM2M1LDAsOS43LTEuNCwxMy45LTQuMmgwLjR2Ny40CgkJYy00LjcsMi42LTEwLjMsNC0xNi42LDRjLTYuNCwwLTExLjUtMi0xNS4zLTUuOWMtMy44LTMuOS01LjgtOS4yLTUuOC0xNS44YzAtNi43LDEuNy0xMi4yLDUuMS0xNi41YzMuNC00LjMsOC40LTYuNSwxNS02LjUKCQljNi42LDAsMTEuNiwyLjIsMTUsNi41QzYxMy45LDI5NC41LDYxNS42LDI5OS44LDYxNS42LDMwNnogTTU4MywzMDIuNGgyNC45Yy0wLjItNC0xLjYtNy4xLTQuMS05LjJjLTIuNS0yLjEtNS4zLTMuMS04LjQtMy4xCgkJYy0zLjEsMC01LjksMS04LjMsMy4xQzU4NC42LDI5NS4zLDU4My4zLDI5OC40LDU4MywzMDIuNHoiLz4KCTxwYXRoIGNsYXNzPSJzdDEiIGQ9Ik02NjMuNiwzMDZ2Mi43aC0zMi41YzAuNCwzLjksMS45LDcsNC40LDkuMmMyLjUsMi4yLDYuMiwzLjMsMTEuMywzLjNzOS43LTEuNCwxMy45LTQuMmgwLjR2Ny40CgkJYy00LjcsMi42LTEwLjMsNC0xNi42LDRjLTYuNCwwLTExLjUtMi0xNS4zLTUuOWMtMy44LTMuOS01LjgtOS4yLTUuOC0xNS44YzAtNi43LDEuNy0xMi4yLDUuMS0xNi41YzMuNC00LjMsOC40LTYuNSwxNS02LjUKCQljNi42LDAsMTEuNiwyLjIsMTUsNi41QzY2MS45LDI5NC41LDY2My42LDI5OS44LDY2My42LDMwNnogTTYzMS4xLDMwMi40SDY1NmMtMC4yLTQtMS42LTcuMS00LjEtOS4yYy0yLjUtMi4xLTUuMy0zLjEtOC40LTMuMQoJCWMtMy4xLDAtNS45LDEtOC4zLDMuMUM2MzIuNywyOTUuMyw2MzEuMywyOTguNCw2MzEuMSwzMDIuNHoiLz4KCTxwYXRoIGNsYXNzPSJzdDEiIGQ9Ik02OTcuNiwyODMuN2gwLjd2Ny4zaC0wLjdjLTMuMywwLTYuNCwwLjYtOS4zLDEuOWMtMi45LDEuMy01LjEsMy4xLTYuNyw1LjR2MjkuMmgtNy43di00M2g2LjdsMC45LDUuNHYxLjMKCQloMC4yQzY4NS44LDI4Ni4yLDY5MS4xLDI4My43LDY5Ny42LDI4My43eiIvPgoJPHBhdGggY2xhc3M9InN0MSIgZD0iTTc3NS42LDI4MC45Yy01LjgtMy44LTEyLjItNS43LTE5LjEtNS43Yy03LDAtMTIuNCwyLjEtMTYuNCw2LjRjLTMuOSw0LjMtNS45LDkuOC01LjksMTYuNXMyLDEyLjMsNS45LDE2LjUKCQljMy45LDQuMyw5LjQsNi40LDE2LjQsNi40YzcsMCwxMy4zLTEuOSwxOS4xLTUuN2gwLjR2Ny42Yy02LjEsMy43LTEyLjcsNS41LTIwLDUuNWMtOC42LDAtMTUuNy0yLjctMjEuMi04LjIKCQljLTUuNS01LjUtOC4zLTEyLjgtOC4zLTIyYzAtOS4yLDIuOC0xNi42LDguMy0yMmM1LjUtNS41LDEyLjYtOC4yLDIxLjItOC4yYzcuMiwwLDEzLjksMS44LDIwLDUuNXY3LjZINzc1LjZ6Ii8+Cgk8cGF0aCBjbGFzcz0ic3QxIiBkPSJNNzg4LDI4Ni45YzQuOS0yLjEsMTAuMS0zLjIsMTUuNy0zLjJjNS42LDAsOS45LDEuNiwxMi45LDQuOWMzLDMuMyw0LjUsNy4yLDQuNSwxMS43djI3LjJoLTYuN2wtMC45LTUuNGgtMC4zCgkJYy00LDQuMi05LjIsNi4yLTE1LjYsNi4yYy0zLjgsMC03LjEtMS4yLTkuNy0zLjVjLTIuNy0yLjMtNC01LjUtNC05LjRjMC00LDEuNi03LjIsNC45LTkuN2MzLjMtMi41LDguMS0zLjcsMTQuNS0zLjdoMTAuMnYtMC43CgkJYzAtMy43LTAuOS02LjQtMi43LThjLTEuOC0xLjYtNS0yLjQtOS41LTIuNGMtNC41LDAtOC43LDEtMTIuNiwyLjlINzg4VjI4Ni45eiBNODEzLjQsMzE1LjN2LTcuMWgtOS4yYy04LjUsMC0xMi43LDIuMi0xMi43LDYuNwoJCXMzLDYuNyw4LjksNi43YzIuNSwwLDQuOS0wLjYsNy4yLTEuOEM4MDkuOSwzMTguNiw4MTEuOCwzMTcuMSw4MTMuNCwzMTUuM3oiLz4KCTxwYXRoIGNsYXNzPSJzdDEiIGQ9Ik04ODQuNSwyODMuN2M0LjYsMCw4LjEsMS42LDEwLjUsNC45YzIuNCwzLjMsMy42LDcsMy42LDExLjN2MjcuNmgtNy43di0yNi4xYzAtMy43LTAuNy02LjMtMi04CgkJYy0xLjMtMS43LTMuNS0yLjYtNi42LTIuNmMtNC44LDAtOC45LDIuNy0xMi4xLDguMXYyOC43aC03Ljd2LTI2LjFjMC0zLjctMC42LTYuMy0xLjktOGMtMS4zLTEuNy0zLjUtMi42LTYuNy0yLjYKCQljLTQuOCwwLTguOSwyLjctMTIuMSw4LjF2MjguN2gtNy43di00M2g2LjdsMC45LDUuNHYxLjNoMC4yYzMuNi01LDguMy03LjUsMTQuMi03LjVjMy4xLDAsNS44LDAuOCw4LDIuNGMyLjIsMS42LDMuOCwzLjcsNC44LDYuMQoJCWgwLjNDODcyLjUsMjg2LjUsODc3LjcsMjgzLjcsODg0LjUsMjgzLjd6Ii8+Cgk8cGF0aCBjbGFzcz0ic3QxIiBkPSJNOTQ3LjksMzIyLjNjLTQuMSw0LTguOCw2LjEtMTQuMyw2LjFjLTUuNSwwLTEwLjItMi4xLTE0LjItNi4yaC0wLjN2MjQuOGgtNy43di02Mi40aDYuN2wwLjksNS40aDAuMwoJCWM0LTQuMiw4LjctNi4yLDE0LjItNi4yYzUuNSwwLDEwLjIsMiwxNC4zLDYuMWM0LjEsNCw2LjEsOS41LDYuMSwxNi4zQzk1NCwzMTIuOCw5NTIsMzE4LjIsOTQ3LjksMzIyLjN6IE05MzIuNSwyOTAuOAoJCWMtNS4xLDAtOS41LDIuMS0xMy4zLDYuM3YxNy43YzMuOCw0LjIsOC4zLDYuMywxMy4zLDYuM2M0LjIsMCw3LjUtMS4zLDEwLTRjMi41LTIuNiwzLjgtNi40LDMuOC0xMS4yYzAtNC44LTEuMy04LjYtMy44LTExLjIKCQlDOTQwLDI5Mi4xLDkzNi43LDI5MC44LDkzMi41LDI5MC44eiIvPgoJPHBhdGggY2xhc3M9InN0MSIgZD0iTTk2NS41LDI4Ni45YzQuOS0yLjEsMTAuMS0zLjIsMTUuNy0zLjJjNS42LDAsOS45LDEuNiwxMi45LDQuOWMzLDMuMyw0LjUsNy4yLDQuNSwxMS43djI3LjJoLTYuN2wtMC45LTUuNAoJCWgtMC4zYy00LDQuMi05LjIsNi4yLTE1LjYsNi4yYy0zLjgsMC03LjEtMS4yLTkuNy0zLjVjLTIuNy0yLjMtNC01LjUtNC05LjRjMC00LDEuNi03LjIsNC45LTkuN2MzLjMtMi41LDguMS0zLjcsMTQuNS0zLjdoMTAuMgoJCXYtMC43YzAtMy43LTAuOS02LjQtMi43LThjLTEuOC0xLjYtNS0yLjQtOS41LTIuNGMtNC41LDAtOC43LDEtMTIuNiwyLjloLTAuNVYyODYuOXogTTk5MC44LDMxNS4zdi03LjFoLTkuMgoJCWMtOC41LDAtMTIuNywyLjItMTIuNyw2LjdzMyw2LjcsOC45LDYuN2MyLjUsMCw0LjktMC42LDcuMi0xLjhDOTg3LjMsMzE4LjYsOTg5LjMsMzE3LjEsOTkwLjgsMzE1LjN6Ii8+Cgk8cGF0aCBjbGFzcz0ic3QxIiBkPSJNMTAxOS44LDI2Ny4xdjguM2gtOC4zdi04LjNIMTAxOS44eiBNMTAxMS44LDMyNy41di00M2g3Ljd2NDNIMTAxMS44eiIvPgoJPHBhdGggY2xhc3M9InN0MSIgZD0iTTEwNjYuMywyODQuNWg2Ljd2NDEuMWMwLDcuMS0xLjcsMTIuNS01LjEsMTYuNGMtMy40LDMuOC04LjQsNS43LTE0LjksNS43cy0xMi40LTEuNC0xNy43LTQuM3YtNy42aDAuNAoJCWM0LjgsMy4xLDEwLjQsNC42LDE2LjgsNC42YzguNiwwLDEyLjktNC42LDEyLjktMTMuN3YtNS41aC0wLjNjLTMuOSw0LjItOC41LDYuMi0xMy45LDYuMnMtMTAuMi0xLjktMTQuNC01LjgKCQljLTQuMi0zLjgtNi4zLTkuMi02LjMtMTYuMXMyLjEtMTIuMyw2LjMtMTYuMWM0LjItMy44LDktNS44LDE0LjQtNS44czEwLDIuMSwxMy45LDYuMmgwLjNMMTA2Ni4zLDI4NC41eiBNMTA2NS4zLDMxNC4zdi0xNy40CgkJYy00LTQuMi04LjItNi4yLTEyLjYtNi4yYy00LjQsMC03LjksMS4zLTEwLjUsMy44Yy0yLjcsMi42LTQsNi4zLTQsMTEuMWMwLDQuOCwxLjMsOC41LDQsMTEuMWMyLjcsMi42LDYuMiwzLjgsMTAuNSwzLjgKCQlDMTA1Ny4xLDMyMC41LDEwNjEuMywzMTguNCwxMDY1LjMsMzE0LjN6Ii8+Cgk8cGF0aCBjbGFzcz0ic3QxIiBkPSJNMTEwOS43LDI4My43YzQuNywwLDguMywxLjYsMTEsNC43YzIuNywzLjEsNCw3LjEsNCwxMS44djI3LjNoLTcuN1YzMDFjMC02LjktMy4xLTEwLjMtOS4zLTEwLjMKCQljLTQuOSwwLTkuNSwyLjctMTMuOCw4LjF2MjguN2gtNy43di00M2g2LjdsMC45LDUuNHYxLjNoMC4yQzEwOTguNywyODYuMiwxMTAzLjksMjgzLjcsMTEwOS43LDI4My43eiIvPgo8L2c+Cjwvc3ZnPgo=">
            </td>
        </tr>
        <!--end::Logo-->
        <tr>
            <td></td>
            <td class="text-sm-end fw-bold fs-4 text-muted mt-7">
                <div>(732) 269-0338</div>
                <div>3 Albatross Pt</div>
                <div>Bayville, New Jersey(NJ), 08721</div>
            </td>
        </tr>
    </table>
    <!--end::Header-->
    <!--begin::Body-->
    <div class="pb-12">
        <!--begin::Wrapper-->
        <div class="d-flex flex-column gap-7 gap-md-10">
            <!--begin::Message-->
            <div class="fw-bolder fs-2">Dear {{ $invoice->customer_name }}
                <span class="fs-6">({{ $invoice->customer_email }})</span>,
                <br>
                <span class="text-muted fs-5">Here are your order details. We thank you for your purchase.</span>
            </div>
            <!--begin::Message-->
            <!--begin::Separator-->
            <div class="separator"></div>
            <!--begin::Separator-->
            <!--begin::Order details-->
            <table class="table table-responsive border-0">
                <tr>
                    <th class="text-muted border-0 p-0">Order ID</th>
                    <th class="text-muted border-0 p-0">Date</th>
                    <th class="text-muted border-0 p-0">Invoice ID</th>
                </tr>
                <tr>
                    <td class="p-0">#{{ $id ?? $invoice->number }}</td>
                    <td class="p-0">{{ $invoice->date()->format('d F, Y') }}</td>
                    <td class="p-0">#{{ $invoice->number }}</td>
                </tr>
            </table>
            <!--end::Order details-->
            <!--begin:Order summary-->
            <table class="table align-middle table-row-dashed fs-6 mb-0 gap">
                <thead>
                    <tr class="border-bottom fs-6 fw-bolder text-muted">
                        <th class="min-w-175px pb-2">Products</th>
                        <th class="min-w-80px text-end pb-2">QTY</th>
                        <th class="min-w-100px text-end pb-2">Total</th>
                    </tr>
                </thead>
                <tbody class="fw-bold text-gray-600">
                    <!--begin::Products-->

                    @foreach ($invoice->subscriptions() as $subscription)
                        <tr>
                            <!--begin::Product-->
                            <td>
                                <div>
                                    <!--begin::Title-->
                                    <div>
                                        <div class="fw-bolder">
                                            {{ $subscription->description }}</div>
                                        <div class="fs-7 text-muted">
                                            {{ $subscription->startDateAsCarbon()->formatLocalized('%e %B, %Y') }}
                                            -
                                            {{ $subscription->endDateAsCarbon()->formatLocalized('%e %B, %Y') }}
                                        </div>
                                    </div>
                                    <!--end::Title-->
                                </div>
                            </td>
                            <!--end::Product-->
                            <!--begin::Quantity-->
                            <td class="text-end" style="text-align: right">{{ $subscription->quantity }}</td>
                            <!--end::Quantity-->
                            <!--begin::Total-->
                            <td class="text-end" style="text-align: right">{{ $subscription->total() }}</td>
                            <!--end::Total-->
                        </tr>
                    @endforeach
                    <!--end::Products-->
                </tbody>
            </table>
            <!--end:Order summary-->
            <table class="table">
                <!--begin::Subtotal-->
                <tr>
                    <td style="width: 65%"></td>
                    <td class="text-end" style="text-align: right">Subtotal</td>
                    <td class="text-end" style="text-align: right">{{ $invoice->subtotal() }}</td>
                </tr>
                <!--end::Subtotal-->

                @foreach ($invoice->taxes() as $tax)
                    <!--begin::VAT-->
                    <tr>
                        <td style="width: 65%"></td>
                        <td style="text-align: right;">
                            {{ $tax->display_name }}
                            {{ $tax->jurisdiction ? ' - ' . $tax->jurisdiction : '' }}
                            ({{ $tax->percentage }}%{{ $tax->isInclusive() ? ' incl.' : '' }})
                        </td>
                        <td>{{ $tax->amount() }}</td>
                    </tr>
                    <!--end::VAT-->
                @endforeach
                <!--begin::Grand total-->
                <tr>
                    <td style="width: 65%"></td>
                    <td class="fs-3 text-dark fw-bolder text-end" style="text-align: right;">Grand Total</td>
                    <td class="text-dark fs-3 fw-boldest text-end" style="text-align: right;">{{ $invoice->total() }}</td>
                </tr>
                <!--end::Grand total-->
            </table>
        </div>
        <!--end::Wrapper-->
    </div>
    <!--end::Body-->

</body>

</html>
