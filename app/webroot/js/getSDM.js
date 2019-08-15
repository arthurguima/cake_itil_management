function indexRdmSdm(idSdm){
  document.getElementById('demandaFrame').src = "URLSDM?OP=SEARCH+SKIPLIST=1+FACTORY=chg+QBE.EQ.chg_ref_num=" + idSdm;
}
