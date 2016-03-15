alter table bphtb_sspd add mutasi_penuj smallint default 0;
alter table bphtb_sspd add harga_transaksi bigint default 0;
update bphtb_sspd set harga_transaksi = npop;
CREATE OR REPLACE FUNCTION bphtb.str_status_validasi(num integer)
  RETURNS character varying AS
$BODY$
declare status_out character varying;
begin

-- aagusti
/*
STATUS VALIDASI:
0 = 'Draft';
1 = 'Validated';
2 = 'Approved';   
*/

select case 
  when num=0 then 'Draft' 
  when num=1 then 'On Validated' 
  when num=2 then 'Approved'
  else 'Unknown' end 
into status_out;

return status_out;
   
end
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;