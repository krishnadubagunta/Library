SELECT count(borrows.bornumber) as borrowCount, docuemnt.title, docuemnt.docid, YEAR(borrows.bdtime) as year
FROM docuemnt, borrows
WHERE borrows.docid = docuemnt.docid
GROUP BY year
ORDER BY year DESC