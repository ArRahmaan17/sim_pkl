/**
 *
 * You can write your JS code here, DO NOT touch the default style file
 * because it will make it harder for you to update.
 * 
 */

"use strict";
function alertClose() {
    swal.close();
}
function getMoment(status = "y", duration) {
    let des = '';
    if (status == 'y') {
        des = 'year';
    } else if (status == 'M') {
        des = 'month';
    } else if (status == 'd') {
        des = 'day';
    } else if (status == 'h') {
        des = 'hour';
    } else if (status == 'm') {
        des = 'minute';
    } else if (status == 's') {
        des = 'second';
    }
    return (duration.get(status) != 0) ? parseInt(duration.get(status)) > 1 ? `${Math.abs(duration.get(status))} ${des}s` :
        `${Math.abs(duration.get(status))} ${des}` : ''
}

function chunkArray(array, size = 5) {
    const chunkedArray = [];
    for (let i = 0; i < array.length; i += size) {
        chunkedArray.push(array.slice(i, i + size));
    }
    return chunkedArray;
}

function chunkResolver(data = window.tasks) {
    data.forEach((element, index) => {
        if (element.length == undefined) {
            data[index] = Object.values(data[index])
        }
    });
    return data;
}
function serializeObject(node) {
    var o = {};
    var a = node.serializeArray();
    $.each(a, function () {
        if (this.value !== "") {
            if (o[this.name]) {
                if (!o[this.name].push) {
                    o[this.name] = [o[this.name]];
                }
                o[this.name].push(this.value || '');
            } else {
                o[this.name] = this.value || '';
            }
        }
    });
    return o;
}
