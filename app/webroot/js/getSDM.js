function indexRdmSdm(idSdm){
  document.getElementById('demandaFrame').src = "https://www-sdm14/CAisd/pdmweb.exe?OP=SEARCH+SKIPLIST=1+FACTORY=chg+QBE.EQ.chg_ref_num=" + idSdm;
}
