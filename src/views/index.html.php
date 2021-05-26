<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Sushi-Bar</title>
    <link rel="stylesheet" href="/assets/stylesheets/bootstrap.css">
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <h1>Sushi-Bar</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-8">
            <table data-seats='<?php echo json_encode($this->get('seats')); ?>' id="seats" class="table table-striped">
                <thead>
                <tr>
                    <th>Gruppe</th>
                    <th>Plätze</th>
                    <th></th>
                </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
        <div class="col-sm-4">
            <div class="form">
                <form action="/" id="add-group" method="POST">
                    <div class="mb-3">
                        <label for="group-size" class="form-label">Gruppengröße</label>
                        <input type="number" id="group-size" max="10" min="1" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Platzieren</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="/assets/javascripts/jquery.min.js"></script>
<script src="/assets/javascripts/application.js"></script>
</body>
</html>