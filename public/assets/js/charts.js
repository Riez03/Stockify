export function generateStockChart(transactionData) {
    const processTransactionData = (data, type) =>
        data.map(item => ({
            month: item.month,
            year: item.year,
            quantity: parseInt(item[`total_quantity`], 10),
        }));

    const mergeDates = (dataIn, dataOut) =>
        [...dataIn, ...dataOut]
            .map(item => new Date(item.year, item.month - 1))
            .sort((a, b) => a - b);

    const addFutureMonths = (uniqueMonths, monthDataMap, count = 6) => {
        const currentMonth = new Date();
        
        for (let i = 0; i < count; i++) {
            const nextMonth = new Date(currentMonth);
            nextMonth.setMonth(currentMonth.getMonth() + i);
            
            const monthString = nextMonth.toLocaleString("default", { month: "long" });
            if (!uniqueMonths.includes(monthString)) {
                uniqueMonths.push(monthString);
                monthDataMap[monthString] = { in: 0, out: 0 };
            }
        }
    };

    const prepareChartData = (uniqueMonths, monthDataMap) => ({
        labels: uniqueMonths,
        datasets: [
            {
                label: "Stock Barang Masuk",
                data: uniqueMonths.map(month => monthDataMap[month]?.in || 0),
                backgroundColor: "rgba(54, 162, 235, 0.6)",
                borderColor: "rgba(54, 162, 235, 1)",
                borderWidth: 1,
                fill: true,
                tension: 0.5,
            },
            {
                label: "Stock Barang Keluar",
                data: uniqueMonths.map(month => monthDataMap[month]?.out || 0),
                backgroundColor: "rgba(255, 99, 132, 0.6)",
                borderColor: "rgba(255, 99, 132, 1)",
                borderWidth: 1,
                fill: true,
                tension: 0.5,
            },
        ],
    });

    const dataIn = processTransactionData(transactionData.DataIn, "in");
    const dataOut = processTransactionData(transactionData.DataOut, "out");
    const sortedDates = mergeDates(dataIn, dataOut);

    const uniqueMonths = [...new Set(sortedDates.map(date => date.toLocaleString("default", { month: "long" })))];
    const monthDataMap = {};

    uniqueMonths.forEach(month => (monthDataMap[month] = { in: 0, out: 0 }));

    dataIn.forEach(({ month, year, quantity }) => {
        const monthString = new Date(year, month - 1).toLocaleString("default", { month: "long" });
        if (monthDataMap[monthString]) {
            monthDataMap[monthString].in = quantity;
        }
    });

    dataOut.forEach(({ month, year, quantity }) => {
        const monthString = new Date(year, month - 1).toLocaleString("default", { month: "long" });
        if (monthDataMap[monthString]) {
            monthDataMap[monthString].out = quantity;
        }
    });

    addFutureMonths(uniqueMonths, monthDataMap);

    const ctx = document.getElementById("stockChart").getContext("2d");

    new Chart(ctx, {
        type: "line",
        data: prepareChartData(uniqueMonths, monthDataMap),
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                title: {
                    display: true,
                    text: "Product Stock Transaction (Next 6 Months)",
                },
                tooltip: {
                    mode: "index",
                    intersect: false,
                },
            },
            scales: {
                x: {
                    title: {
                        display: true,
                        text: "Month",
                    },
                },
                y: {
                    title: {
                        display: true,
                        text: "Stock Quantity",
                    },
                    beginAtZero: true,
                },
            },
        },
    });
}
