SELECT count(borrows.docid) as amountBorrowed, docuemnt.title as docuemntTitle, branch.libid, branch.lname
FROM branch, borrows, docuemnt
WHERE branch.libid = borrows.libid and borrows.docid = docuemnt.docid
GROUP BY borrows.docid, branch.libid, branch.lname
ORDER BY branch.libid DESC, amountBorrowed DESC