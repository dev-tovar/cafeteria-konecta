<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header h4">
            Consulta para conocer el producto con más Stock
          </div>

          <div class="card-body">
            <code>
              SELECT * FROM products WHERE stock = (SELECT MAX(stock) FROM
              products);
            </code>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card">
          <div class="card-header h4">
            Consulta para conocer el producto con más vendido
          </div>

          <div class="card-body">
            <code>
              SELECT s.id_product , SUM(s.cantidad) AS TotalVentas, p.nombre
              FROM cafeteriakonecta.sale_products s join products p ON(p.id =
              s.id_product) GROUP BY s.id_product ORDER BY SUM(s.cantidad) DESC
              LIMIT 1
            </code>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  mounted() {
    console.log("Component mounted.");
  },
};
</script>
