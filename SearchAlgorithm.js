function SearchAlgorithm(Query, DataArry) {
    let data = DataArry;
    let query = Query;

    // example
    // let query = $("#searchbar").val();
    // let data = ["Apple", "Banana", "Cherry", "Date", "Elderberry"];

    const organizedArray = data.map(item => {
        const queryChars = query.toLowerCase().split("");
        const itemChars = item.toLowerCase().split("");
        let matchedChars = 0;

        // Compare characters
        for (let i = 0; i < queryChars.length; i++) {
            if (itemChars.includes(queryChars[i])) {
                matchedChars++;
            }
        }

        return { item, query, matchedChars };
    });

    organizedArray.sort((a, b) => b.matchedChars - a.matchedChars);
    return organizedArray;
}

{   //  example just paste this code in html file 


//<!doctype html>
/* <html lang="en">

<head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

</head>

<body>

    <h1>search algorithm</h1>
    <div class="row">
        <div class="col-12 m-5">
            <input type="text" id="searchbar" placeholder="Search here" class="row">
        </div>
    </div>
    <h1>Reasults</h1>
    <ul class="row" id="ull">
        <li class="col-12">a</li>
    </ul>











    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
        </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"
        integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
        </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(document).ready(() => {
            let ul = $("#ull");


            function SearchAlgorithm(Query, DataArry) {
                let data = DataArry;
                let query = Query;

                // example
                // let query = $("#searchbar").val();
                // let data = ["Apple", "Banana", "Cherry", "Date", "Elderberry"];

                const organizedArray = data.map(item => {
                    const queryChars = query.toLowerCase().split("");
                    const itemChars = item.toLowerCase().split("");
                    let matchedChars = 0;

                    // Compare characters
                    for (let i = 0; i < queryChars.length; i++) {
                        if (itemChars.includes(queryChars[i])) {
                            matchedChars++;
                        }
                    }

                    return { item, query, matchedChars };
                });

                organizedArray.sort((a, b) => b.matchedChars - a.matchedChars);
                return organizedArray;
            }



            $("#searchbar").on("keyup", () => {

                let query = $("#searchbar").val();
                let data = ["Apple", "Banana", "Cherry", "Date", "Elderberry"];
                let html = ``;
                let organizedArray = SearchAlgorithm(query, data)

                console.log("Organized Array:", organizedArray);

                organizedArray.forEach(e => {
                    html += `<li>${e.item}</li>`;
                });

                ul.html(html);
            })


        })



    </script>
</body>

</html> */
}