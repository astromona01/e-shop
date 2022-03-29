const express = require('express');
const bodyParser = require('body-parser');
const mysql = require('mysql');
const fs = require("fs");
const Blob = require('node:buffer').Blob

const pool = mysql.createPool({
    connectionLimit: 10,
    host: 'localhost',
    user: 'root',
    password: '123',
    database: 'shop',
})



const app = express();
const port = process.env.port || 5000;

app.use(bodyParser.urlencoded({ extended: false }));
app.use(bodyParser.json());

// const blobToImage = async (blob) => {
//   return await new Promise(resolve => {
//     const url = URL.createObjectURL(blob)
//     let img = `<img/>`
//     img.onload = () => {
//       URL.revokeObjectURL(url)
//       resolve(img)
//     }
//     img.src = url
//   })
// }
async function toDataURL_node(url) {
  let response = await fetch(url);
  let contentType = response.headers.get("Content-Type");
  let buffer = await response.buffer();
  return "data:" + contentType + ';base64,' + buffer.toString('base64');
}

app.get('/', (req, res) => {
    pool.getConnection((err, conn) => {
        if (err) {
            return console.log(err)
        }
        conn.query(
          `SELECT Products.id, Products.name, Products.price, Products.count, Category.name as Category, Products.image from Products
           INNER JOIN Category on Products.category_id = Category.id;`,
          (err, rows) => {
            conn.release() //return the conn to pool
            if (err) {
                return console.log(err)
            }
            rows.map(el => {
              const b64 = Buffer.from(el.image).toString('base64')
              const imgSource = "data:application/octet-stream;base64,"+b64
              el.image = imgSource
              // const img = `<img src=${imgSource} />`
            })
            res.send(rows)
        })
    })
})
app.get('/men-clothes', (req, res) => {
    pool.getConnection((err, conn) => {
        if (err) {
            return console.log(err)
        }
        conn.query(
          `SELECT Products.id, Products.name, Products.price, Products.count, Category.name as Category from Products
           INNER JOIN Category on Products.category_id = Category.id WHERE Category.name = 'Men clothes';`,
          (err, rows) => {
              conn.release() //return the conn to pool
              if (err) {
                  return console.log(err)
              }
              res.send(rows)
          })
    })
})
app.get('/women-clothes', (req, res) => {
    pool.getConnection((err, conn) => {
        if (err) {
            return console.log(err)
        }
        conn.query(
          `SELECT Products.id, Products.name, Products.price, Products.count, Category.name as Category from Products
           INNER JOIN Category on Products.category_id = Category.id WHERE Category.name = 'Women clothes';`,
          (err, rows) => {
              conn.release() //return the conn to pool
              if (err) {
                  return console.log(err)
              }
              res.send(rows)
          })
    })
})
app.post('/new-user', (req, res) => {
  pool.getConnection((err, conn) => {
    if (err) return err
    conn.query(`INSERT INTO Users SET ?`, [req.body],
      (err, rows) => {
        conn.release()
        if (err) console.log(err)
        res.send(rows)
      }
    )
  })
})

app.listen(port, () => console.log(`Listening ${port} port`))