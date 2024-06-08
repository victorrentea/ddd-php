Create view STOCK_VIEW as
select STOCK.PRODUCT_ID,
       STOCK.ITEMS as STOCK
-- 1) expune 2 coloane, nu tot
-- 2) daca imi alter STOCK pot pastra coloanele viewului nemodif
-- 3) pot include MICI calcule - sum(rezervari
    from STOCK;
SELECT * FROM STOCK_VIEW
WHERE PRODUCT_ID = 1;